import pathlib, re
root = pathlib.Path('resources/views')
used_keys = set()
for path in root.rglob('*.blade.php'):
    text = path.read_text(encoding='utf-8')
    used_keys.update(m.group(1) for m in re.finditer(r"__\('messages\.([a-zA-Z0-9_]+)'\)", text))
for locale in ['en','fr','es']:
    file = pathlib.Path('resources/lang')/locale/'messages.php'
    content = file.read_text(encoding='utf-8')
    defined = set(m.group(1) for m in re.finditer(r"'([a-zA-Z0-9_]+)'\s*=>", content))
    miss = sorted(used_keys - defined)
    print(locale, 'missing', len(miss))
    for k in miss:
        print(' ', k)
