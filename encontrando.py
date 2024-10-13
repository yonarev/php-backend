# encontrando.py
def busqueda_secuencial(lista, elemento):
    """Busca un elemento en una lista de forma secuencial.
    Args:
        lista: La lista donde se realizará la búsqueda.
        elemento: El elemento a buscar.

    Returns:
        La posición del elemento si se encuentra, -1 en caso contrario.
    """
    for i in range(len(lista)):
        if lista[i] == elemento:
            return i
    return -1

# Ejemplo de uso:
mi_lista = [1, 3, 5, 7, 9]
elemento_a_buscar = 5
resultado = busqueda_secuencial(mi_lista, elemento_a_buscar)
if resultado != -1:
    print("El elemento se encuentra en la posición:", resultado)
else:
    print("El elemento no se encuentra en la lista.") 

# RESULTADO
# El elemento se encuentra en la posición: 2
# PS C:\Users\notebook> 
