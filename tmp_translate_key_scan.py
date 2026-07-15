import pathlib
import re
root = pathlib.Path('resources/views')
keys = set()
for path in root.rglob('*.blade.php'):
    text = path.read_text(encoding='utf-8')
    keys.update(m.group(1) for m in re.finditer(r"__\('messages\.([a-zA-Z0-9_]+)'\)", text))
print('Found keys:', len(keys))
for key in sorted(keys):
    print(key)
