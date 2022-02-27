const api = 'http://localhost:81';
var notes_ul, note_form;

const onclick_notes_ul = e => {
  e.preventDefault();
  if(e.target.nodeName == 'A'){
    let id = e.target.getAttribute('href');
    fetch(`${api}/notes/${id}`)
      .then(res => res.json())
      .then(json => {
        let note = json.note;
        // Add note values to the form
        note_form.id.value = note.id;
        note_form.title.value = note.title;
        note_form.content.value = note.content;
      });
  }
};

const onsubmit_note_form = e => {
  e.preventDefault();
  // a note object based on the form values
  let note = {};
  note.title = e.target.title.value;
  note.content = e.target.content.value;
  // url and method for posting a new note
  let url = `${api}/notes`;
  let method = 'POST';
  // if id has a value we are updating a note
  if(e.target.id.value){
    url += `/${e.target.id.value}`;
    method = 'PUT';
    note.id = e.target.id.value;
  }
  let request = new Request(url, {
    method: method,
    mode: 'cors',
    headers: {
      'Content-Type':'application/json'
    },
    body: JSON.stringify(note)
  });
  fetch(request)
    .then(res => res.json())
    .then(json => {
      if(request.method == 'PUT'){
        let a = notes_ul.querySelector(`a[href="${json.note.id}"]`);
        a.textContent = json.note.title;
      }
    });
};

document.addEventListener('DOMContentLoaded', e => {
  notes_ul = document.getElementById('notes');
  note_form = document.forms.note;
  // initial request for all notes
  fetch(`${api}/notes`)
    .then(res => res.json())
    .then(json => {
      notes_ul.innerHTML = '';
      json.notes.forEach(note => {
        let li = document.createElement('li');
        let a = document.createElement('a');
        a.href = note.id;
        a.textContent = note.title;
        li.append(a);
        notes_ul.append(li);
      });
    });
  // event listers for the UI
  notes_ul.addEventListener('click', onclick_notes_ul);
  note_form.addEventListener('submit', onsubmit_note_form);
});