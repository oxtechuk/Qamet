
import sys
import re

file_path = r'c:\wamp64\www\ga\public\store.css'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

replacement = """
.product__badge-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  color: rgba(0, 166, 62, 1);
  background-color: rgba(221, 247, 233, 1);
  font-weight: 600;
  border-radius: 12px;
  padding: 12px 8px;
  flex: 1 1 0;
  min-width: 90px;
  text-align: center;
}
"""

# Find the spot after .product__badges block and before .product__badge-item svg
# We'll search for the gap.
pattern = r'(\.product__badges\s*\{[\s\S]*?\}\s*)(\.product__badge-item svg)'
new_content = re.sub(pattern, r'\1' + replacement + r'\n\2', content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_content)

print("Replacement successful")
