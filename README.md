# 🩺 MedCarePro — Sistema di Gestione Appuntamenti Medici

**MedCarePro** è una web app realizzata in **PHP puro** per la gestione di appuntamenti in uno studio medico.  
Progettato per offrire un’esperienza intuitiva sia per pazienti che per amministratori, il sistema include funzionalità di login multiutente, calendario settimanale e notifiche dinamiche.

## 📌 Contesto del progetto

Il progetto nasce con l’obiettivo di simulare un’applicazione professionale per studi medici, sviluppata **senza framework** per comprendere e padroneggiare appieno il funzionamento di un’app PHP da zero.

🔧 Tecnologie utilizzate:
- PHP puro (senza framework)
- MySQL / MariaDB
- HTML5 / CSS3 moderno
- JavaScript (solo vanilla)
- FullCalendar.js per la visualizzazione del calendario

## 👥 Ruoli supportati

- **Cliente (Paziente)**:
  - Può registrarsi, accedere, prenotare appuntamenti.
  - Visualizza lo storico delle richieste (con stato: confermato, in attesa, rifiutato).
  - Riceve feedback immediati.

- **Admin (Segreteria / Studio)**:
  - Accede al **pannello di controllo**.
  - Gestisce e approva o rifiuta le richieste dei pazienti.
  - Visualizza il calendario settimanale con gli appuntamenti confermati.

## ⚙️ Funzionalità principali

- 🔐 Login sicuro con sessione attiva e controllo del ruolo
- 🗓️ Prenotazione appuntamenti (evita sovrapposizioni)
- 📬 Notifiche automatiche all’utente sullo stato della prenotazione
- 📅 Calendario interattivo per l’admin con visuale settimanale (FullCalendar)
- 📱 Interfaccia **responsive** e accessibile anche da mobile
- ✅ Interazione semplificata: l’utente accede in pochi click


## 🛠️ Installazione locale

1. Clona il repository:

```bash
git clone https://github.com/tuo-username/MedCarePro.git

2. Sposta la cartella nel tuo ambiente locale (es. htdocs di XAMPP)

3. Crea un database medcarepro e importa il file SQL:

-- Apri phpMyAdmin e importa il file database/medcarepro.sql

4. Avvia il server locale e accedi a:

http://localhost/MedCarePro/public/index.php

🧠 Autore
Realizzato con passione da Claudio Maldera
🧪 Progetto didattico per esercitazione su PHP puro, UI moderna e gestione utenti realistica.
