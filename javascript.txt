/**
 * Scripts
 */

(function() {
/* функция получения данных */
  function getRecords(cb) {
    const formData = new FormData();
    formData.append('action', 'getEquipment');

    fetch('./backend.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then((data) => {
      cb(data);
    });
  }

/* функция обновления новой позиции */
  function updateRecords() {
    getRecords((data) => {
      const table = document.querySelector('#tblEquipment');
      table.innerHTML = '';

      for(let i=0; i< data.length; i++) {
        table.innerHTML += `
          <tr class="equipment-table__tr">
            <td class="equipment-table__td">${data[i].id}</td>
            <td class="equipment-table__td">${data[i].name}</td>
            <td class="equipment-table__td">${data[i].power}</td>
            <td class="equipment-table__td">
              <a href="#" class="equipment-table__edit">Edit</a>
            </td>
            <td class="equipment-table__td">
              <a href="#" class="equipment-table__delete">Delete</a>
            </td>
          </tr>
        `;
      }
    });
  }
  
/* функция правки выбранной позиции */
  function editRecord(row) {
    const id = row.querySelectorAll('td')[0].innerHTML;
    const name = row.querySelectorAll('td')[1].innerHTML;
    const power = row.querySelectorAll('td')[2].innerHTML;

    document.querySelector('#editWindow').style.display = 'block';

    document.querySelector('#fieldId').value = id;
    document.querySelector('#fieldName').value = name;
    document.querySelector('#fieldPower').value = power;
  }

/* функция удаления выбранной позиции */
  function deleteRecord(row) {
    if(!confirm('Really delete record?')) return;

    const id = row.querySelector('td').innerHTML;

    const formData = new FormData();
    formData.append('action', 'removeEquipment');
    formData.append('id', id);

    fetch('./backend.php', {
      method: 'POST',
      body: formData
    })
    .then(() => {
      row.remove();
    });
  }

  document.querySelector('#btnSave').addEventListener('click', function() {
    const id = document.querySelector('#fieldId').value;
    const name = document.querySelector('#fieldName').value;
    const power = document.querySelector('#fieldPower').value;

    const formData = new FormData();
    formData.append('action', 'saveEquipment');
    formData.append('id', id);
    formData.append('name', name);
    formData.append('power', power);

    fetch('./backend.php', {
      method: 'POST',
      body: formData
    })
    .then(() => {
      document.querySelector('#editWindow').style.display = 'none';
      updateRecords();
    });
  });

/* отмена редактирования, сокрытие окна правки */
  document.querySelector('#btnCancel').addEventListener('click', function() {
    document.querySelector('#editWindow').style.display = 'none';
  });

/* добавление позиции, открытие окна правки */
  document.querySelector('#btnAdd').addEventListener('click', function() {
    document.querySelector('#editWindow').style.display = 'block';

    document.querySelector('#fieldId').value = '';
    document.querySelector('#fieldName').value = '';
    document.querySelector('#fieldPower').value = '';
  });

/* обработка событий в таблице позиций */
  window.addEventListener('click', function(e) {
    if(e.target.classList.contains('equipment-table__edit')) {
      e.preventDefault();
      editRecord(e.target.closest('tr'));
      return;
    }
    if(e.target.classList.contains('equipment-table__delete')) {
      e.preventDefault();
      deleteRecord(e.target.closest('tr'));
      return;
    }
  });

  updateRecords();
})();
