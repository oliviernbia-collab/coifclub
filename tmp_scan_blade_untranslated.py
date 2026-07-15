import re
from pathlib import Path
root = Path('resources/views')
for path in sorted(root.rglob('*.blade.php')):
    lines = path.read_text(encoding='utf-8').splitlines()
    for i, line in enumerate(lines, 1):
        if "__('messages." in line or '@lang' in line or 'trans(' in line:
            continue
        if re.search(r'>[^<>{}]*[A-Za-zÀ-ÿ][^<>{}]*<', line):
            text = re.sub(r'<[^>]+>', '', line).strip()
            if text and len(text) > 2 and not re.match(r'^[\s/<>!@=-]+$', text):
                if re.search(r'^[\w\s\-\d\(\)\?\!\:;,\u00C0-\u017F]+$', text):
                    print(f'{path}:{i}: {text}')
