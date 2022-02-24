if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  console.log('beforecaught');
  $('#btnInstall').removeClass('d-none').click(() => {
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice
      .then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
          $('#btnInstall').addClass('d-none');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  });
});


function fetchInfoAndPreset() {
$.get("api/keys", function(keys, status) {
  $.get("api/owners", function(users, status) {

  })
  .then((users) => {
    // console.log(keys);
    // console.log(users);
    createKeyCards(keys, users);
  });
});
}

function createKeyCards(keys, users) {
users.sort((a, b) => a.surname.localeCompare(b.surname));
let selectOptions = '';
for (u in users) {
  if (!users.hasOwnProperty(u))
    continue;

  let user = users[u];
  selectOptions += `<option value='${user.id}'>${user.surname} ${user.name}</option>`;
}

for (i in keys) {
  let key = keys[i];
  let card = $(`#key-${key.id}`);
  let append = false;
  if(card.length == 0) {
    append = true;
    card = $('#keyTemplate').clone();
    card.removeClass('default-hidden');
    card.attr('id', `key-${key.id}`);

    $(card.find('.key-name')[0]).html(key.name);
    $(card.find('.card-header')[0]).css('background-color', key.color);
    $(card.find('.card-footer')[0]).css('background-color', key.color);

    let select = $(card.find('.custom-select')[0]);
    select.append(selectOptions);
    select.on('change', () => {
      console.log(select.val(), select.find(":selected").text());
      let name = select.find(":selected").text().split(' ')[1];
      let changeHolderModal = $('#changeHolderModal');
      $(changeHolderModal.find('.modal-header')[0]).css('background-color', key.color);
      $(changeHolderModal.find('.modal-footer')[0]).css('background-color', key.color);
      $('#changeHolderLabel').text(`${name} vyplň prosím údaje`);

      $('#btnSaveHolder').unbind( "click" ).click(() => {
        let newHolderData = {
          'id': key.id,
          'bookedBy': parseInt(select.val()),
        };
        let inputDate = $('#inputDate');
        let inputReason = $('#inputReason');

        let bookedUntil = inputDate.datepicker('getDate');
        if (bookedUntil == null) {
          bookedUntil = new Date();
          bookedUntil.setDate(new Date().getDate()+1);
        }
        // console.log(bookedUntil.toLocaleDateString('sk'));
        // return;
        newHolderData.booked_until = $.datepicker.formatDate('yy-mm-dd', bookedUntil);
        newHolderData.reason = inputReason.val();
        console.log(newHolderData);

        $.post("api/key/change", newHolderData, function(data, status){
            fetchInfoAndPreset();
        });
        changeHolderModal.modal('hide');
      });

      changeHolderModal.on('hidden.bs.modal', function () {
        select.find('option:disabled').prop('selected', true);
        $('#inputReason').val('').prop( "disabled", false);
        $('#inputDate').datepicker('setDate', null).prop( "disabled", false);
        $('#switchNotNeeded').prop('checked', false);
      });

      changeHolderModal.modal();
    });
  }

  let date = new Date(key.booked_until);
  var yesterday = new Date();
  yesterday.setDate(new Date().getDate()-1);
  if (date < yesterday) {
    $(card.find('.very-card')[0]).css("box-shadow", "0 4px 10px 0 rgba(106,168,79,0.30), 0 4px 20px 0 rgba(106,168,79,0.18)");
    $(card.find('.key-date')[0]).addClass("text-success");
  }
  else {
    $(card.find('.very-card')[0]).css("box-shadow", "0 4px 10px 0 rgba(205,56,29,0.30), 0 4px 20px 0 rgba(205,56,29,0.18)");
    $(card.find('.key-date')[0]).addClass("text-danger");
  }

  $(card.find('.key-date')[0]).html(date.toLocaleDateString('sk'));

  if (key.reason == '')
    $(card.find('.key-comment')[0]).addClass('text-muted').html('bez komentára');
  else
    $(card.find('.key-comment')[0]).removeClass('text-muted').html(key.reason);


  let keyPhone = $(card.find('.key-phone')[0]);
  keyPhone.html(key.owner.phone);
  keyPhone.attr('href', 'tel:' + key.owner.phone);

  let keyOwner = $(card.find('.key-owner')[0]);
  let messengerLink = 'https://m.me/' + key.owner.facebook.split('/').pop();
  keyOwner.html(`${key.owner.name} ${key.owner.surname}`);
  keyOwner.attr('href', messengerLink);

  if (append)
    card.appendTo('#cardRow').hide().fadeIn(500);
}
$('[data-toggle="tooltip"]').tooltip();
}

$(document).ready( () => {
fetchInfoAndPreset();

$.datepicker.setDefaults(
  $.extend(
    $.datepicker.regional['sk']
  )
);

let datepicker = $('#inputDate');
datepicker.datepicker({
    minDate: 0
});
var today = new Date();
var tomorrow = new Date();
var yesterday = new Date();
tomorrow.setDate(today.getDate()+1);
yesterday.setDate(today.getDate()-1);
datepicker.attr('placeholder', tomorrow.toLocaleDateString('sk') + ' (zajtra)');

$('#switchNotNeeded').change(function() {
    // this will contain a reference to the checkbox
  if (this.checked) {
    datepicker.prop( "disabled", true).datepicker("option", "minDate", -1).datepicker('setDate', yesterday).val(datepicker.val() + ' (včera)');
    $('#inputReason').prop( "disabled", true).val('kľúče sú voľné');
    console.log("mak")
  } else {
    datepicker.prop( "disabled", false).datepicker("option", "minDate", 0).datepicker('setDate', null);
    $('#inputReason').prop( "disabled", false).val('');
  }
});

let validations = {
  name: false,
  surname: false,
  phone: false,
  facebook: false
};

$('#inputPhone').on('input', (e) => {
  console.log(e.target.value);

  let correct = e.target.value.replace(/[^0-9\+]/g, '');
  correct = correct.replace(/^([1-9])/, '+420$1');
  correct = correct.replace(/^0/, "+421");
  correct = correct.replace(/^(\+[0-9]{0,3})?([0-9]{1,3})?([0-9]{1,3})?([0-9]{1,3})?(.*)$/, "$1 $2 $3 $4");
  correct = correct.trim();

  if (correct.length == 16)
    validations.phone = true;
  else
    validations.phone = false;

  $('#inputPhone').val(correct);
});

$('#inputSurname').on('input', (e) => {
  let correct = e.target.value.replace(/[^a-zA-ZÀ-ž]/g, '');
  correct = correct.charAt(0).toUpperCase() + correct.slice(1).toLowerCase();

  if (correct.length > 2)
    validations.surname = true;
  else
    validations.surname = false;

  $('#inputSurname').val(correct);
});

$('#inputFirstName').on('input', (e) => {
  let correct = e.target.value.replace(/[^a-zA-ZÀ-ž]/g, '');
  correct = correct.charAt(0).toUpperCase() + correct.slice(1).toLowerCase();

  if (correct.length > 2)
    validations.name = true;
  else
    validations.name = false;

  $('#inputFirstName').val(correct);
});

$('#inputFacebookLink').on('input', (e) => {
  let res = /.*\.com\/[0-9a-zA-Z\.]{2,}$/.test(e.target.value);
  if (res || e.target.value == '') {
    $('#inputFacebookLink').removeClass('border-danger').siblings('.invalid-feedback').slideUp();
    if (!e.target.value == '')
      validations.facebook = true;
    else
      validations.facebook = false;
  }
  else {
    $('#inputFacebookLink').addClass('border-danger').siblings('.invalid-feedback').slideDown();
    validations.facebook = false;
  }
});
$('#btnSaveUser').click(() => {
  for (let i in validations) {
    if (validations[i] == false) {
        $('#alertInvalidHolderInfo').slideDown();
        console.log(i, validations[i]);
        return;
    }
  }
  let holder = {
    name: $('#inputFirstName').val(),
    surname: $('#inputSurname').val(),
    facebook: $('#inputFacebookLink').val(),
    phone: $('#inputPhone').val(),
  }
  $.post("api/owner/new", holder, function(data, status){
      console.log('úspech');
      $("#cardRow").empty();
      fetchInfoAndPreset();
      $('#addUserModal').modal('hide');
      $('#successModal').modal();
      setTimeout(function(){
        $('#successModal').modal('hide')
      }, 2000);
  });

});
})
