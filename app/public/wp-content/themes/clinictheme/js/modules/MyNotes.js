import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    // =================================================================
    //                       Events
    // =================================================================

    events() {
        $("#my-notes").on("click", ".delete-note", this.deleteNote);            // delete btn
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this));     // edit btn
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this)); // save btn
        $(".submit-note").on("click", this.createNote.bind(this));              // new btn
    }

    // =================================================================
    //                       Functions
    // =================================================================

    deleteNote(e) {
        var thisNote = $(e.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE', 
            success: (response)=> {
                thisNote.slideUp();
                console.log("Delete successfull");
                console.log(response);
                if(response.user_note_count < 10) {
                    $(".note-limit-message").removeClass("active");
                }
            },
            error: (response) => {
                console.log("Delete ERROR");
                console.log(response);
            }
        })
    }

    updateNote(e) {
        var thisNote = $(e.target).parents("li");
        var noteUpdates = {
            'title': thisNote.find(".note-title-field").val(),
            'content': thisNote.find(".note-body-field").val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'POST', 
            data: noteUpdates,
            success: (response)=> {
                this.makeNoteReadOnly(thisNote);
                console.log("post/update successfull");
                console.log(response);
            },
            error: (response) => {
                console.log("post/update ERROR");
                console.log(response);
            }
        })
    }

    createNote(e) {
        var newNote = {
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'private'
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', clinic_data.nonce);
            },
            url: clinic_data.root_url + '/wp-json/wp/v2/note/',
            type: 'POST', 
            data: newNote,
            success: (response)=> {
                $(".new-note-title, .new-note-body").val('');
                $(`<li data-id="${response.id}">
                    <input readonly class="note-title-field" value="${response.title.raw}">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                    </li>`).prependTo("#my-notes").hide().slideDown();
                console.log("post/update successfull");
                console.log(response);
            },
            error: (response) => {
                if(response.responseText == "Per user note limit is 10 notes, please delete a note to free up space.") {
                    $(".note-limit-message").addClass('active');
                }
                console.log("post/update ERROR");
                console.log(response);
            }
        })
    }

    editNote(e) {
        var thisNote = $(e.target).parents("li");
        if (thisNote.data("state") == "editable") {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }
    }

    makeNoteEditable(thisNote) {
        thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
        thisNote.data("state", "editable");
    }

    makeNoteReadOnly(thisNote){
        thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        thisNote.find(".update-note").removeClass("update-note--visible");
        thisNote.data("state", "cancel");
    }

}

export default MyNotes;