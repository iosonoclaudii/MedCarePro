# 🩺 MedCarePro — Sistema di Gestione Appuntamenti Medici

**MedCarePro** è una web app realizzata in **PHP puro** per la gestione degli appuntamenti in uno studio medico.  
Progettata per offrire un’esperienza semplice e professionale sia per pazienti che per amministratori, include login multiutente, calendario settimanale interattivo e gestione centralizzata delle prenotazioni.

## 📌 Contesto del progetto

Il progetto nasce con l’obiettivo di simulare un’applicazione reale per studi medici, sviluppata **senza framework** per comprendere e padroneggiare appieno il funzionamento di un'app PHP da zero, lavorando su sessioni, ruoli, validazioni, UI responsive e logiche back-end.

🔧 Tecnologie utilizzate:
- PHP puro (senza framework)
- MySQL / MariaDB
- HTML5 / CSS3 moderno
- JavaScript (vanilla)
- FullCalendar.js per il calendario

## 👥 Ruoli supportati

- **Cliente (Paziente)**:
  - Può registrarsi, accedere, prenotare appuntamenti.
  - Visualizza lo storico delle richieste con stato aggiornato (confermato, in attesa, rifiutato).
  - Riceve feedback immediato dal sistema.

- **Admin (Segreteria / Studio)**:
  - Accede a un pannello di controllo.
  - Gestisce le richieste ricevute dai pazienti.
  - Approva, modifica o rifiuta le prenotazioni.
  - Visualizza il calendario settimanale con tutti gli appuntamenti confermati.

## ⚙️ Funzionalità principali

- 🔐 Login sicuro con sessioni e gestione dei ruoli
- 🗓️ Prenotazione appuntamenti con verifica di disponibilità
- 📬 Notifiche in tempo reale per conferme e rifiuti
- 📅 Calendario interattivo lato admin con FullCalendar.js
- 📱 Interfaccia moderna e completamente responsive
- ✅ Navigazione fluida con feedback visivi ed esperienza ottimizzata

## 🛠️ Installazione locale

1. Clona il repository:

```bash
git clone https://github.com/tuo-username/MedCarePro.git
```

2. Sposta la cartella nel tuo ambiente locale (es. `htdocs` di XAMPP)

3. Crea un database `medcarepro` e importa il file SQL:

- Apri phpMyAdmin
- Clicca su "Importa"
- Seleziona `database/medcarepro.sql` e conferma

4. Avvia il server locale e visita:

```bash
http://localhost/MedCarePro/public/index.php
```

---

## 🧠 Autore

Realizzato con passione da **Claudio Maldera**  
🧪 Progetto didattico per approfondire lo sviluppo in PHP puro, la gestione utenti e la creazione di interfacce moderne accessibili.
