var contactsArray;
var editingContactId;

var UserContact = Backbone.Model.extend();

$(document).ready(function () {
    fetch_data();

    $('#add_button').click(function () {
        $('#user_form')[0].reset();
        $('.modal-title').text("Add Contact");
        $('#action').val('Add');
        $('#userModal').modal('show');
    });

    $('#action').click(function () {
        if ($('#action').val() == 'Add') {
            addContact();
        } else if ($('#action').val() == 'Edit') {
            editContact();
        }
    });
});

function fetch_data() {
    var Contact = Backbone.Model.extend({
        urlRoot: baseUrl + "index.php/ContactListController/contacts",
        idAttribute: 'id',
    });

    var c = new Contact();

    c.fetch({
        async: false,
        success: function (data) {
            console.log(data.attributes.contacts);
            contactsArray = data.attributes.contacts;
        }
    });
}

function editContactPopUp(id) {
    var userName;
    var email;
    var telephoneNo;

    editingContactId = id;
    for (i = 0; i < contactsArray.length; i++) {

        if (contactsArray[i].contactId == id) {
            userName = contactsArray[i].contactName;
            email = contactsArray[i].contactEmail;
            telephoneNo = contactsArray[i].contactTelephoneNo;

            for (y = 0; y < contactsArray[i].contactTags.length; y++) {
                if (contactsArray[i].contactTags[y] == 'Friends') {
                    console.log('Hello world');
                    $('input[name="tag1"]').attr('checked', 'checked');
                }

                if (contactsArray[i].contactTags[y] == 'Work') {
                    $('input[name="tag2"]').attr('checked', 'checked');
                }

                if (contactsArray[i].contactTags[y] == 'Family') {
                    $('input[name="tag3"]').attr('checked', 'checked');
                }
            }
        }
        $('#user_form')[0].reset();
        $('.modal-title').text("Edit Contact");
        $("input#name").val(userName);
        $("input#email_address").val(email);
        $("input#telephone_no").val(telephoneNo);
        $('#action').val('Edit');
        $('#userModal').modal('show');
    }
}

function addContact() {
    var name = $("input#name").val();
    var email = $("input#email_address").val();
    var telephoneNo = parseInt($("input#telephone_no").val());

    var isFriendChecked = null;
    var isWorkChecked = null;
    var isFamilyChecked = null;

    if ($('input[name="tag1"]:checked').length > 0) {
        isFriendChecked = 'Friends';
    }

    if ($('input[name="tag2"]:checked').length > 0) {
        isWorkChecked = 'Work';
    }

    if ($('input[name="tag3"]:checked').length > 0) {
        isFamilyChecked = 'Family';
    }

    console.log(isFriendChecked);
    console.log(isWorkChecked);
    console.log(isFamilyChecked);

    if (!(name == "" || email == "" || telephoneNo == "")) {
        if (isFriendChecked == null && isWorkChecked == null && isFamilyChecked == null) {
            $('#message').html('Please add tags for the contact');
            $('#message').show().fadeOut(4000);
        } else {
            if (Number.isInteger(telephoneNo)) {
                var Contact = Backbone.Model.extend({
                    urlRoot: baseUrl + "index.php/ContactListController/addContact",
                    idAttribute: 'id',
                });

                var c = new Contact();

                var contactDetails = {
                    'name': name,
                    'email': email,
                    'telephoneNo': telephoneNo,
                    'tags': {
                        'friends': isFriendChecked,
                        'work': isWorkChecked,
                        'family': isFamilyChecked
                    }
                }

                c.save(contactDetails, {
                    async: false,
                    success: function (data) {
                        fetch_data();
                        console.log(data);
                        $('#user_form')[0].reset();
                        $('#message').html(data.attributes.response);
                        $('#message').show().fadeOut(4000);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            } else {
                $('#message').html('Your telephone number is wrong');
                $('#message').show().fadeOut(4000);
            }
        }
    } else {
        $('#message').html('Fields are empty');
        $('#message').show().fadeOut(4000);
    }
}

function editContact() {
    var name = $("input#name").val();
    var email = $("input#email_address").val();
    var telephoneNo = parseInt($("input#telephone_no").val());

    var isFriendChecked = null;
    var isWorkChecked = null;
    var isFamilyChecked = null;

    if ($('input[name="tag1"]:checked').length > 0) {
        isFriendChecked = 'Friends';
    }

    if ($('input[name="tag2"]:checked').length > 0) {
        isWorkChecked = 'Work';
    }

    if ($('input[name="tag3"]:checked').length > 0) {
        isFamilyChecked = 'Family';
    }

    console.log(isFriendChecked);
    console.log(isWorkChecked);
    console.log(isFamilyChecked);

    if (!(name == "" || email == "" || telephoneNo == "")) {
        if (isFriendChecked == null && isWorkChecked == null && isFamilyChecked == null) {
            $('#message').html('Please add tags for the contact');
            $('#message').show().fadeOut(4000);
        } else {
            if (Number.isInteger(telephoneNo)) {
                var Contact = Backbone.Model.extend({
                    urlRoot: baseUrl + "index.php/ContactListController/editContact",
                    idAttribute: 'id',
                });

                var c = new Contact();

                var editContactDetails = {
                    'contactId': editingContactId,
                    'name': name,
                    'email': email,
                    'telephoneNo': telephoneNo,
                    'tags': {
                        'friends': isFriendChecked,
                        'work': isWorkChecked,
                        'family': isFamilyChecked
                    }
                }

                c.save(editContactDetails, {
                    async: false,
                    success: function (data) {
                        fetch_data();
                        console.log(data);
                        $('#user_form')[0].reset();
                        $('#message').html(data.attributes.response);
                        $('#message').show().fadeOut(4000);
                    },
                    error: function (error) {
                        console.log(error);
                        $('#message').html('Failed to update the contact');
                        $('#message').show().fadeOut(4000);
                    }
                });
            } else {
                $('#message').html('Your telephone number is wrong');
                $('#message').show().fadeOut(4000);
            }
        }
    } else {
        $('#message').html('Fields are empty');
        $('#message').show().fadeOut(4000);
    }
}