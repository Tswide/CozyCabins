/*------------------------------------CALENDRIER-------------------------------------------------*/

/*
  Creationd du calendrier en format tableau
*/ 
function createCalendar(year, month) {
  let date = new Date(year, month - 1, 1);
  let calendar = '<thead><tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr></thead>';
  calendar += '<tbody>';

  let currentMonth = date.getMonth() + 1;
  while (date.getMonth() + 1 === currentMonth) {
    calendar += '<tr>';
    for (let i = 0; i < 7; i++) {
      if (date.getMonth() + 1 === currentMonth) {
        calendar += '<td';
        if (date.getDate() === new Date().getDate() && date.getMonth() + 1 === new Date().getMonth() + 1 && date.getFullYear() === new Date().getFullYear()) {
          calendar += ' class="current-day"';
        }
        calendar += ' data-date="' + date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + '">' + date.getDate() + '</td>';
        date.setDate(date.getDate() + 1);
      }
    }
    calendar += '</tr>';
  }
  calendar += '</tbody>';

  return calendar;
}

/*
  MAJ du calendrier lors du changement de dates
*/ 
function updateCalendar() {
  let today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth() + 1;
  let calendarTable = document.getElementById('calendarTable');
  calendarTable.innerHTML = createCalendar(year, month);
  document.getElementById('currentMonthYear').textContent = monthNames[month - 1] + ' ' + year;
}

/*
  Recuperation de la date lors du clique afin d'envoyer ou non le pop up de reservation
*/ 
function handleDateSelection(event) {
  let selectedDate = event.target.getAttribute('data-date');
  console.log(selectedDate);
}

let monthNames = [
  'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

let previousButton = document.getElementById('previous');
let nextButton = document.getElementById('next');

previousButton.addEventListener('click', function() {
  let currentMonthYear = document.getElementById('currentMonthYear').textContent.split(' ');
  let month = monthNames.indexOf(currentMonthYear[0]) + 1;
  let year = parseInt(currentMonthYear[1]);

  if (year < new Date().getFullYear() || (year === new Date().getFullYear() && month <= new Date().getMonth() + 1)) {
    return; // Ne fait rien si la date actuelle ou une date antérieure est sélectionnée
  }

  if (month === 1) {
    month = 12;
    year--;
  } else {
    month--;
  }

  let calendarTable = document.getElementById('calendarTable');
  calendarTable.innerHTML = createCalendar(year, month);
  document.getElementById('currentMonthYear').textContent = monthNames[month - 1] + ' ' + year;
});

nextButton.addEventListener('click', function() {
  let currentMonthYear = document.getElementById('currentMonthYear').textContent.split(' ');
  let month = monthNames.indexOf(currentMonthYear[0]) + 1;
  let year = parseInt(currentMonthYear[1]);

  if (month === 12) {
    month = 1;
    year++;
  } else {
    month++;
  }

  let calendarTable = document.getElementById('calendarTable');
  calendarTable.innerHTML = createCalendar(year, month);
  document.getElementById('currentMonthYear').textContent = monthNames[month - 1] + ' ' + year;
});

const calendarTable = document.getElementById('calendarTable');
calendarTable.addEventListener('click', handleDateSelection);

updateCalendar();


/*
  HightLight reservations
*/ 

// // Fonction pour mettre en évidence les dates réservées dans le calendrier
// function highlightReservedDates(chaletId) {
//   // Récupérer les dates réservées pour le chalet spécifié depuis la base de données
//   // Remplacez "votre_table_reservations" par le nom de votre table de réservations
//   let xhr = new XMLHttpRequest();
//   xhr.onreadystatechange = function() {
//       if (this.readyState === 4 && this.status === 200) {
//           let datesReservees = JSON.parse(this.responseText);

//           // Parcourir les cellules du calendrier pour trouver les dates réservées
//           let calendarTable = document.querySelector('.calendarTable_' + chaletId);
//           const cells = calendarTable.getElementsByTagName('td');
//           for (let cell of cells) {
//               const date = cell.dataset.date;

//               // Vérifier si la date est réservée
//               if (datesReservees.includes(date)) {
//                   cell.style.backgroundColor = 'red';
//               }
//           }
//       }
//   };
//   xhr.open("GET", "../api/reservations.php");
//   xhr.send();
// }

// // Appeler la fonction pour mettre en évidence les dates réservées lors du chargement du calendrier
// let calendarTables = document.querySelectorAll('[class^="calendarTable_?chalet_id="]');
// calendarTables.forEach(function(calendarTable) {
//   let chaletId = calendarTable.id.split('_')[1];
//   highlightReservedDates(chaletId);
// });

/*------------------------------------FORMULAIRE-------------------------------------------------*/

let popup = document.getElementById('popup');
let closeBtn = document.getElementsByClassName('close-btn')[0];

// Fonction pour afficher le pop-up
function showPopup() {
  popup.style.display = 'block';
}

// Fonction pour masquer le pop-up
function hidePopup() {
  popup.style.display = 'none';
}

let chaletId = document.querySelector('main').getAttribute('key');

// Sélectionner toutes les cellules de date du calendrier
const dateCells = document.querySelectorAll('#calendarTable td');

// Ajouter un écouteur de clic à chaque cellule de date
dateCells.forEach(function (cell) {
  cell.addEventListener('click', function () {
    let date = this.dataset.date;
    let chaletId = this.closest('main').getAttribute('key');

    // Vérifier si la date a déjà une réservation dans la table 'reservations' pour l'ID du chalet
    checkReservationExists(date, chaletId)
    .then(function (reservationExists) {
      // Si aucune réservation n'existe, ouvrir le pop-up et envoyer les informations à la base de données
      if (!reservationExists) {
        showPopup();
      } else {
        console.log("La date est déjà sélectionnée.");
      }
    })
    .catch(function (error) {
      console.error('Erreur lors de la vérification de la réservation :', error);
    });

    document.getElementById('button_submit').addEventListener('click', function(){
      // sendReservationToDatabase(date, chaletId, nom, prenom, email, telephone, nombrePersonnes, petitDejeuner, repas, spa, allIn);
      console.log('hello')
    })
  });
});

// Vérifier si une réservation existe pour la date donnée et l'ID du chalet dans la base de données
function checkReservationExists(date, chaletId) {
  let urlReservation = 'http://localhost/CozyCabins/api/reservations.php';
  urlReservation += '?chalet_id=' + encodeURIComponent(chaletId);
  urlReservation += '&date_reservation=' + encodeURIComponent(date);
  // Effectuer une requête fetch pour vérifier si une réservation existe
  return fetch(urlReservation)
    .then(response => response.text())
    .then(result => {
      // La réponse doit être un booléen indiquant si une réservation existe ou non
      return result === 'true';
    })
    .catch(error => {
      console.error('Erreur lors de la vérification de la réservation :', error);
      return false;
    });
}


// Envoyer les informations de réservation à la base de données avec l'ID du chalet comme signature
function sendReservationToDatabase(date, chaletId, nom, prenom, email, telephone, nombrePersonnes, petitDejeuner, repas, spa, allIn) {
  // Construire l'URL avec les paramètres de requête
  let urlForm = 'http://localhost/CozyCabins/api/formulaire.php';
  urlForm += '?chalet_id=' + encodeURIComponent(chaletId);
  urlForm += '&date_reservation=' + encodeURIComponent(date);
  urlForm += '&nom=' + encodeURIComponent(nom);
  urlForm += '&prenom=' + encodeURIComponent(prenom);
  urlForm += '&email=' + encodeURIComponent(email);
  urlForm += '&telephone=' + encodeURIComponent(telephone);
  urlForm += '&nombre_personnes=' + encodeURIComponent(nombrePersonnes);
  urlForm += '&petit_dejeuner=' + encodeURIComponent(petitDejeuner);
  urlForm += '&repas=' + encodeURIComponent(repas);
  urlForm += '&spa=' + encodeURIComponent(spa);
  urlForm += '&all_in=' + encodeURIComponent(allIn);

  // Effectuer une requête GET pour envoyer les informations de réservation
  return fetch(urlForm)
    .then(response => response.text())
    .then(result => {
      // Traiter la réponse du serveur
      return result === 'true';
    })
    .catch(error => {
      console.error('Erreur lors de l\'envoi de la réservation :', error);
      return false;
    });
}


// Gestionnaire d'événement pour le bouton de fermeture
closeBtn.addEventListener('click', hidePopup);