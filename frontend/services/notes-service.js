var NotesService = {
  init: function () {
    NotesService.getAllNotes();
  },

  addNoteFromForm: function () {
    const title = $("#noteTitle").val().trim();
    const content = $("#noteContent").val().trim();

    if (!title || !content) {
      Utils.showError("Title and content are required.");
      return;
    }

    const token = localStorage.getItem("user_token");
    if (!token) {
      Utils.showError("You are not logged in.");
      UserService.logout();
      return;
    }

    const payload = Utils.parseJwt(token);
    const user_id = payload?.user?.id;

    if (!user_id) {
      Utils.showError("Invalid session. Please login again.");
      UserService.logout();
      return;
    }

    NotesService.addNote({
      title: title,
      content: content,
      user_id: user_id,
      category_id: 1
    });

    // Reset form
    $("#noteTitle").val("");
    $("#noteContent").val("");
  },

  renderNotes: function (notes) {
    const list = $("#notesList");
    if (!list.length) return;

    if (!notes || notes.length === 0) {
      list.html(`<p class="text-muted">No notes yet.</p>`);
      return;
    }

    const currentUser = NotesService.getCurrentUser();
    let html = "";
    notes.forEach(n => {
      let buttons = "";
      if (currentUser && (currentUser.role === 'admin' || currentUser.id == n.user_id)) {
        buttons = `
          <button class="btn btn-sm btn-warning me-2" onclick="NotesService.editNote(${n.id}, '${n.title.replace(/'/g, "\\'")}', '${n.content.replace(/'/g, "\\'")}')">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="NotesService.deleteNote(${n.id})">Delete</button>
        `;
      }
      html += `
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">${n.title}</h5>
            <p class="card-text">${n.content}</p>
            <div class="mt-2">${buttons}</div>
          </div>
        </div>
      `;
    });

    list.html(html);
  },

  getAllNotes: function () {
    RestClient.get(
      "notes",
      function (data) {
        NotesService.renderNotes(data);
      },
      function (xhr) {
        if (xhr.status === 401 || xhr.status === 403) {
          Utils.showError("Unauthorized. Please login again.");
          UserService.logout();
        } else {
          Utils.showError("Failed to load notes.");
        }
      }
    );
  },

  addNote: function (note) {
    RestClient.post(
      "notes",
      note,
      function () {
        Utils.showSuccess("Note added successfully!");
        NotesService.getAllNotes();
      },
      function (xhr) {
        if (xhr.status === 401 || xhr.status === 403) {
          Utils.showError("Unauthorized.");
          UserService.logout();
        } else {
          Utils.showError("Failed to add note.");
        }
      }
    );
  },

  getCurrentUser: function () {
    const token = localStorage.getItem("user_token");
    if (!token) return null;
    const payload = Utils.parseJwt(token);
    return payload?.user || null;
  },

  editNote: function (id, currentTitle, currentContent) {
    const newTitle = prompt("Edit title:", currentTitle);
    if (newTitle === null) return; // Cancelled
    const newContent = prompt("Edit content:", currentContent);
    if (newContent === null) return; // Cancelled

    if (!newTitle.trim() || !newContent.trim()) {
      Utils.showError("Title and content cannot be empty.");
      return;
    }

    RestClient.put(
      `notes/${id}`,
      { title: newTitle.trim(), content: newContent.trim() },
      function () {
        Utils.showSuccess("Note updated successfully!");
        NotesService.getAllNotes();
      },
      function (xhr) {
        if (xhr.status === 401 || xhr.status === 403) {
          Utils.showError("Unauthorized.");
          UserService.logout();
        } else if (xhr.status === 404) {
          Utils.showError("Note not found.");
        } else {
          Utils.showError("Failed to update note.");
        }
      }
    );
  },

  deleteNote: function (id) {
    if (!confirm("Are you sure you want to delete this note?")) return;

    RestClient.delete(
      `notes/${id}`,
      function () {
        Utils.showSuccess("Note deleted successfully!");
        NotesService.getAllNotes();
      },
      function (xhr) {
        if (xhr.status === 401 || xhr.status === 403) {
          Utils.showError("Unauthorized.");
          UserService.logout();
        } else if (xhr.status === 404) {
          Utils.showError("Note not found.");
        } else {
          Utils.showError("Failed to delete note.");
        }
      }
    );
  }
};
