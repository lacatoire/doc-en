<?php
/**
 * Check that each modified reference page contains at least MIN_LINKS distinct
 * outgoing internal links.
 *
 * Elements counted (they render as <a href> in PhD):
 *   <function>, <classname>, <exceptionname>, <interfacename>, <enumname>
 *   <link linkend="…">, <xref linkend="…">
 *
 * Self-references (the page's own xml:id) are excluded.
 *
 * Usage (from doc-en root):
 *   git diff "$BASE"...HEAD --name-only --diff-filter=d | grep '\.xml$' \
 *     | grep '^reference/' | php .github/scripts/check-internal-links.php
 */

declare(strict_types=1);

const MIN_LINKS = 3;

const LINK_TAGS = ['function', 'classname', 'exceptionname', 'interfacename', 'enumname'];

// Stub/alias pages that are legitimately too short to reach the threshold.
const SKIP_FILES = [
    'reference/misc/functions/die.xml',
    'reference/filesystem/functions/delete.xml',
];

$files = [];
while (($line = fgets(STDIN)) !== false) {
    $file = trim($line);
    if ($file !== '') {
        $files[] = $file;
    }
}

$violations = 0;

foreach ($files as $relPath) {
    if (in_array($relPath, SKIP_FILES, true)) {
        continue;
    }

    if (!is_file($relPath)) {
        continue;
    }

    $xml = file_get_contents($relPath);
    if ($xml === false) {
        continue;
    }

    // Only check individual reference pages, not book/chapter/setup overview files.
    if (!str_contains($xml, '<refentry')) {
        continue;
    }

    $pageId = extractPageId($xml);
    $links  = collectLinks($xml, $pageId);
    $count  = count($links);

    if ($count < MIN_LINKS) {
        echo "File {$relPath} has {$count} internal link(s) (minimum: " . MIN_LINKS . ").\n";
        $violations++;
    }
}

if ($violations > 0) {
    echo "\n{$violations} page(s) have fewer than " . MIN_LINKS . " internal links.\n";
    echo "Add <function>, <classname>, <link linkend>, or <xref linkend> elements to improve SEO.\n";
}

exit(0);

function extractPageId(string $xml): string
{
    if (preg_match('/xml:id=["\']([^"\']+)["\']/', $xml, $m)) {
        return $m[1];
    }
    return '';
}

function collectLinks(string $xml, string $pageId): array
{
    $seen = [];

    // Semantic elements that PhD renders as links.
    foreach (LINK_TAGS as $tag) {
        preg_match_all(
            '/<' . $tag . '(?:\s[^>]*)?>([^<]+)<\/' . $tag . '>/',
            $xml,
            $matches
        );
        foreach ($matches[1] as $name) {
            $id = tagToId($tag, trim($name));
            if ($id !== $pageId) {
                $seen[$id] = true;
            }
        }
    }

    // Explicit cross-references.
    preg_match_all('/<(?:link|xref)\s[^>]*\blinkend=["\']([^"\']+)["\']/', $xml, $matches);
    foreach ($matches[1] as $linkend) {
        if ($linkend !== $pageId) {
            $seen[$linkend] = true;
        }
    }

    return array_keys($seen);
}

function tagToId(string $tag, string $name): string
{
    $slug = strtolower(str_replace('_', '-', $name));

    return match ($tag) {
        'function'                                          => 'function.' . $slug,
        'classname', 'exceptionname', 'interfacename', 'enumname' => 'class.' . $slug,
        default                                             => $slug,
    };
}
