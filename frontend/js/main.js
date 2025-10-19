document.getElementById('addNoteForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const title = document.getElementById('noteTitle').value;
    const content = document.getElementById('noteContent').value;

    if (title && content) {
        addNoteToList(title, content);
        document.getElementById('addNoteForm').reset();
    }
});

function addNoteToList(title, content) {
    const notesList = document.getElementById('notesList');
    const noteElement = document.createElement('div');
    noteElement.className = 'col-12';
    noteElement.innerHTML = `
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">${title}</h5>
                <p class="card-text">${content}</p>
            </div>
        </div>
    `;

    if (notesList.firstElementChild.classList.contains('text-muted')) {
        notesList.innerHTML = '';
    }

    notesList.appendChild(noteElement);
}