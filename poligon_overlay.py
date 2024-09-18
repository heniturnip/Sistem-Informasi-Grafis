from shapely.geometry import Polygon
import matplotlib.pyplot as plt

# Definisi dua poligon
poligon_1 = Polygon([(2, 2), (4, 2), (4, 4), (2, 4)])
poligon_2 = Polygon([(3, 3), (5, 3), (5, 5), (3, 5)])

# Operasi Union
poligon_union = poligon_1.union(poligon_2)
print(f'poligon union: {poligon_union}')

# Operasi Intersection
poligon_intersection = poligon_1.intersection(poligon_2)
print(f'poligon intersection: {poligon_intersection}')

# Visualisasi
fig, ax = plt.subplots(1, 3, figsize=(15, 5))

# Poligon awal
ax[0].fill(*poligon_1.exterior.xy, color='blue', alpha=0.5, label='Poligon 1')
ax[0].fill(*poligon_2.exterior.xy, color='green', alpha=0.5, label='Poligon 2')
ax[0].set_title('Poligon Awal')
ax[0].legend()

# Union
ax[1].fill(*poligon_union.exterior.xy, color='purple', alpha=0.5, label='Union')
ax[1].set_title('Union (Penggabungan)')
ax[1].legend()

# Intersection
if not poligon_intersection.is_empty:
    ax[2].fill(*poligon_intersection.exterior.xy, color='orange', alpha=0.5, label='Intersection')
    ax[2].set_title('Intersection (Irisan)')
    ax[2].legend()
else:
    ax[2].text(0.5, 0.5, 'Tidak Ada Irisan', fontsize=15, ha='center', va='center')
    ax[2].set_title('Intersection (Irisan)')

with open('hasil_union_intersection.txt', 'w') as file:
    file.write(f"Union: {poligon_union}\n")
    file.write(f"Intersection: {poligon_intersection}\n")
    print("Hasil union dan intersection disimpan di hasil_union_intersection.txt")

plt.show()
