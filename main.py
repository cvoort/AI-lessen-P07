# Opdracht 1
print("Hello, World!")

# Opdracht 2
tekst = "Hello"
getal = 5
kommagetal = 3.14

print(tekst)
print(getal)
print(kommagetal)

# Opdracht 3
# naam = input("Wat is je naam? ")
# leeftijd = input("Wat is je leeftijd? ")

# print(f"Hello, {naam}! Jij bent {leeftijd} jaar oud.")

# Opdracht 4
getal1 = 4
getal2 = 6

plus = getal1 + getal2
min = getal1 - getal2
keer = getal1 * getal2
deel = getal1 / getal2

print(plus)
print(min)
print(keer)
print(deel)
print("extra som: keer + plus")
print(keer + plus)

# Opdracht 5
boeken = ["De hobbit", "1984", "Percy Jackson"]

print(boeken)

boeken.append("DnD Monster Manual")
print(boeken)

# Opdracht 6

leeftijd = int(input("Hoe oud ben jij? "))

if leeftijd >= 18:
    print("Je bent oud genoeg om te stemmen")
else:
    print("Je bent niet oud genoeg om te stemmen")

# Opdracht 7
for i in range(1,11):
    print(i)

# Opdracht 8
def hallo():
    print("Hallo, wereld!")

hallo()