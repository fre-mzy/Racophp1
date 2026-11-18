
<?php
// RACO WEBSITE SHARED CONFIGURATION

if (!function_exists('h')) {
    function h($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('photo')) {
    function photo($file, $alt, $class = '') {
        $path = __DIR__ . '/../assets/img/' . $file;

        if (is_file($path)) {
            return '<img class="' . h($class) . '" src="assets/img/' .
                h($file) . '" alt="' . h($alt) . '" loading="lazy">';
        }

        return '<div class="ph ' . h($class) . '">
            <span>PHOTO TAG<br><b>' . h($file) . '</b><br>' .
            h($alt) . '</span>
        </div>';
    }
}

// Google Sheets CSV connection and temporary caching
if (!function_exists('sheet_rows')) {
    function sheet_rows($url) {
        if (!$url) {
            return [];
        }

        $cache = sys_get_temp_dir() . '/raco_scholars.csv';

        if (!is_file($cache) || time() - filemtime($cache) > 600) {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 15,
                    'user_agent' => 'RACO Website'
                ]
            ]);

            $data = @file_get_contents($url, false, $context);

            if ($data !== false && strlen($data) > 10) {
                file_put_contents($cache, $data);
            }
        }

        if (!is_file($cache)) {
            return [];
        }

        $handle = fopen($cache, 'r');

        if (!$handle) {
            return [];
        }

        $rows = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (array_filter($row, function ($value) {
                return trim((string)$value) !== '';
            })) {
                $rows[] = $row;
            }
        }

        fclose($handle);

        // Remove UTF-8 BOM from the first heading
        if (!empty($rows[0][0])) {
            $rows[0][0] = preg_replace('/^\xEF\xBB\xBF/', '', $rows[0][0]);
        }

        return $rows;
    }
}

// Convert Google Drive image links into displayable image links
if (!function_exists('drive_img')) {
    function drive_img($value) {
        $value = trim((string)$value);

        if ($value === '') {
            return '';
        }

        if (preg_match('~/d/([a-zA-Z0-9_-]+)~', $value, $match)) {
            return 'https://drive.google.com/thumbnail?id=' .
                $match[1] . '&sz=w1000';
        }

        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $value, $match)) {
            return 'https://drive.google.com/thumbnail?id=' .
                $match[1] . '&sz=w1000';
        }

        if (filter_var($value, FILTER_VALIDATE_URL) &&
            in_array(parse_url($value, PHP_URL_SCHEME), ['http', 'https'], true)) {
            return $value;
        }

        return '';
    }
}

// Main website settings
$S = [
    'n'     => 'RACO Commission',
    's'     => 'Child and Rural Care Initiative',
    'since' => 2003,

    // Published Google Sheets CSV link for the Scholars page
    'sheet' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vR9m6VlnqMmkEw_oi9vXLDzgIeUPxp3uULTF9BtmqpauwsCys061pOn4SRtC7CdQaghzlnw5nOSXrpO/pub?gid=656297882&single=true&output=csv',

    'ga'    => '',
    'wa'    => '2347080004902',
    'mail'  => 'info@racochildinitiative.org',

    'address' => 'No. 33 Adebambo Street, Araromi, Ibeju-Lekki, Lagos State',

    'ph' => [
        ['0802 262 8461', 'Hotline 1 (ES)'],
        ['0802 699 4164', 'Hotline 3'],
        ['0708 000 4902', 'Official WhatsApp']
    ]
];
