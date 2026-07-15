import pathlib
import re

root = pathlib.Path('resources/views/admin')
keywords = [
    r'Accueil', r'Dashboard', r'Utilisateurs', r'Employés', r'Salons', r'Services',
    r'Catégories', r'Boutique', r'Réservations', r'Paiements', r'Remboursements',
    r'Promotions', r'Politique', r'Clients', r'Calendrier', r'Info Salon', r'Horaires',
    r'Inventaire', r'Personnalisation', r'Rapports', r'Contrôle total',
    r'Super administrateur', r'Retour', r'Gestion des', r'Marol Hair', r'Admin Control',
    r'Aucune réservation', r'Services populaires', r'Réservations aujourd\'hui',
    r'Promotions actives', r'Clients fidèles'
]
pat = re.compile('|'.join(keywords))
output = []
for path in sorted(root.rglob('*.blade.php')):
    with path.open(encoding='utf-8') as f:
        for i, line in enumerate(f, 1):
            if pat.search(line) and '__(' not in line and '@lang' not in line:
                output.append(f"{path}:{i}: {line.strip()}")
with open('tmp_admin_scan_output.txt', 'w', encoding='utf-8') as out:
    out.write('\n'.join(output))
