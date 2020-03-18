# Projekt "COGNI LINGA"

## Tematyka

Tematyką projektu jest aplikacja do nauki języków obcych na wzór Profesor Henry.

## Technologie projektu

Aplikacja jest napisana za pomocą: PHP, HTML, CSS, JS. Back-end aplikacji jest oparty o strukturę View-Controller. Baza danych używa MySql.

## Obsługa aplikacji

Panel powitalny przedstawia ofertę aplikacji:

* Uczenie się fiszek
* Odsłuch wymowy
* Tworzenie zestawów fiszek
* Ranking globalny

Aby móc używać wszystkich wymienionych funkcji aplikacji trzeba się w niej zarejestrować.
Przy rejestracji wymagane są dwie wartości, jedna jest opcjonalna:

* Nazwa użytkownika **_[wymagane]_**
* Hasło **_[wymagane]_**
* Kod rejestracji **_[opcjonalne]_**

### Kod rejestracji

Kod rejestracji jest opcjonalny, ponieważ wskazuje na rolę użytkownika.
Role:

* **_Użytkownik_** - brak kodu
* **_Nauczyciel_** - kod jest wymagany
* **_Administrator_** - kod jest wymagany

Według założeń kod nauczycielski jest odbierany od administratora organizacji mającej zamiar używać aplikacji.

### Możliwości poszczególnych ról użytkowniów

#### Użytkownik - '_Uczeń_'

* Tworzenie zestawów oraz edycja tych, które zostały przez niego utworzone
* Podgląd publicznych zestawów do nauki
* Uczenie się w trybach:
  * **_Fiszki_**
  * **_Pisanie_**
* Branie udziału w rankingu globalnym i tygodniowym
* Dodawanie zestawów do **_ulubionych_**
* Korzystanie z **_historii uczenia_** się
* Wyszukiwanie zestawów po słowach kluczowych _(zakładka szukaj)_
* Dezaktywowanie konta _(ustawienia konta)_
* Zmiana hasła _(ustawienia konta)_

Zakładki w aplikacji dostępne dla użytkownika - **_ucznia_**:

![Zakładki dostępne dla użytkownika](dok1.png)

#### Nauczyciel

Konto nauczyciela może korzystać z tych samych funkcji co zwykłe konto (ucznia) oraz:

* Tworzenie nowych kategorii oraz przypisywanie zdjęć do nich

Dodatkowa zakładka w aplikacji dostępna dla nauczyciela:

![Zakładki dostępne dla nauczyciela](dok2.png)

#### Administrator

Konto administratora może korzystać z powyższych opcji (nauczyciel i uczeń) oraz:

* Dostęp do edycji i usuwania wszystkich zestawów
* Wyświetlanie się w panelu aplikacji również zestawów, które są ustawione jako **_prywatne_**
* Widok wszystkich użytkowników w aplikacji, możliwość **_aktywowania_** i dezaktywowania konta

Dodatkowa zakładka w aplikacji dostępna dla administratora:

![Zakładki dostępne dla administratora](dok3.png)

### Tryby nauki

#### Fiszki

W trybie nauki **_fiszki_** użytkownik może przeglądać hasła zawarte w zestawie nauki w dwóch **_kolejnościach_** (pojęcie oraz jego definicja w języku obcym) oraz **_odsłuchiwanie ich wymowy_**.

#### Pisanie

W trybie nauki **_pisanie_** użytkownik wpisuje pojęcie lub jego definicję w języku obcym (w zależności od ustawienia **_kolejności_**). Aplikacja sprawdza poprawność oraz przechodzi do następnego pojęcia. Za każde poprawne pojęcie użytkownik otrzymuje konkretną ilość punktów do rankingu globalnego i tygodniowego (domyślnie są to 3 punkty).

#### Opcje dostępne w trybach

![Zakładki dostępne dla administratora](dok4.png)

Od lewej:

1. **_Reset postępu_** aktualnej nauki (dostępne w trybie fiszki oraz pisanie)
2. **_Zamiana kolejności_** wyświetlania się języków (dostępne w trybie fiszki oraz pisanie)
3. Wyłączenie odczytywania **_wymowy słówek_** (dostępne tylko w trybie fiszki)

### Dodawanie zestawów

Aby dodać zestaw nauki, trzeba dodać w nim conajmniej dwie pary pojęć. Inne wymagane pola to:

* **_Nazwa zestawu_** (maksymalnie 48 znaków)
* **_Opis zestawu_** (maksymalnie 255 znaków)
* **_Język pojęcia i definicji_** (do wyboru: _polski_, _angielski_, _niemiecki_)
* **_Kategoria zestawu_** (do wyboru, tworzone przez nauczycieli i administratorów)
* **_Dostęp do zestawu_** (prywatny lub publiczny)