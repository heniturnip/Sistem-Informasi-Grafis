import numpy as np
import matplotlib.pyplot as plt

# Definisi poligon sebagai serangkaian titik
poligon = np.array([[1, 1], [5, 1], [5, 5], [3, 6], [1, 5]])

# Titik yang akan diuji
titik_uji = np.array([3, 3])

def point_in_polygon(titik, poligon):
    n = len(poligon)
    x, y = titik
    inside = False
    p1x, p1y = poligon[0]
    for i in range(n + 1):
        p2x, p2y = poligon[i % n]
        if y > min(p1y, p2y):
            if y <= max(p1y, p2y):
                if x <= max(p1x, p2x):
                    if p1y != p2y:
                        xinters = (y - p1y) * (p2x - p1x) /(p2y - p1y) + p1x
                    if p1x == p2x or x <= xinters:
                        inside = not inside
        p1x, p1y = p2x, p2y

    return inside

hasil = point_in_polygon(titik_uji, poligon)
print(f"Titik {titik_uji} berada di dalam poligon: {hasil}")

# Visualisasi poligon dan titik uji
plt.figure()
poligon_plot = np.vstack([poligon, poligon[0]])

with open('hasil_titik_dalam_poligon.txt', 'w') as file:
    file.write(f'Titik {titik_uji} berada di dalam poligon:{hasil}')
    print(f'Hasil titik disimpan di hasil_titik_dalam_poligon.txt')

# Tambahkan titik awal di akhir untuk menutup poligon
plt.plot(poligon_plot[:, 0], poligon_plot[:, 1], color='blue', label='Poligon')
plt.scatter(titik_uji[0], titik_uji[1], color='red', label='Titik Uji')
plt.title('Titik Uji dan Poligon')
plt.xlabel('X')
plt.ylabel('Y')
plt.legend()
plt.grid(True)
plt.show()
