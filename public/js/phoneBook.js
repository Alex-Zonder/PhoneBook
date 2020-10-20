var app = new Vue({
    el: '#phoneBook',
    data: {
        phones: phoneBook,
        search: ''
    },
    computed: {
        filterPhones() {
            if (this.search == '') return this.phones;
            return this.phones.filter(phone =>
                (phone.name != null && phone.name.indexOf(this.search) == 0)
                || (phone.last_name != null && phone.last_name.indexOf(this.search) == 0)
                || (phone.email != null && phone.email.indexOf(this.search) == 0)
            )
        },
    },
    methods: {
        findById(id) {
            for (var key in this.phones) if (this.phones[key].id == id) return key;
        },
        deleteEntry(id) {
            let phonesArrId = app.findById(id);
            if (confirm(`Удалить запись: ${this.phones[phonesArrId].name} ${this.phones[phonesArrId].last_name}?`)) {
                fetch('/phones?delete=' + this.phones[phonesArrId].id)
                    .then(response => response.text())
                    .then(text => { alert(text) });
                this.phones.splice(phonesArrId, 1);
            }
        },
        editEntry(id = -1) {
            $("#phoneBook").hide();
            appEdit.phone = id > -1 ? this.phones[app.findById(id)] : {id: -1};
            $("#editTable").show();
        }
    },
});




var appEdit = new Vue({
    el: '#editTable',
    data: {
        phone: {id:'', name:'', last_name:'', email:'', phone:''},
    },
    methods: {
        back() {
            fetch('/phones?get=list')
                .then(response => response.json())
                .then(data => app.phones = data);
            $("#phoneBook").show();
            $("#editTable").hide();
        },
        save() {
            if (this.phone.id > -1) this.update();
            else this.newEntry();
        },
        update() {
            fetch('/phones?update=' + this.phone.id + '&vals=' + JSON.stringify(this.phone))
                .then(response => response.text())
                .then(text => {
                    if (text == 'ok') {
                        this.back();
                    }
                    else alert('Ошибка сохранения!\n- ' + JSON.parse(text).join("\n- "));
                });
        },
        newEntry() {
            fetch('/phones?newEntry=new&vals=' + JSON.stringify(this.phone))
                .then(response => response.text())
                .then(text => {
                    if (text == 'ok') {
                        this.back();
                    }
                    else alert('Ошибка сохранения!\n- ' + JSON.parse(text).join("\n- "));
                });
        },

        /**
         * Work with photo
         */
        loadPhoto() {
            $('#file-input').trigger('click');
        },
        onFileChange: function(e) {
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;

            this.sendPhoto(files[0]);
        },
        sendPhoto(file) {
            var data = new FormData();
            data.append('photo', file);
            data.append('phoneId', this.phone.id);
            fetch('', {
                method: 'POST',
                body: data
            })
            .then(response => response.text())
            .then(text => {
                if (text.match('^ok')) {
                    let imageName = text.split('ok:')[1];
                    this.phone.image = imageName;
                }
                else { alert(text); }
            });
        },
        removePhoto: function (e) {
            if (confirm('Удалить фото?')) {
                fetch('/phones?deletePhoto=' + this.phone.image + '&phoneId=' + this.phone.id)
                    .then(response => response.text())
                    .then(text => {
                        if (text == 'ok') {
                            this.phone.image = '';
                        }
                        else { alert(text); }
                    });
            }
        }
    }
});
