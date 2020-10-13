<style media="screen">
    .phone {
        margin: 2px;
        width: calc(49%);
        float:left;
        border: 1px solid white;
        border-radius: 4px;
        float:left;
        margin: 5px 3px 5px 3px;
        box-shadow: 0px 0px 4px grey;
    }
    @media (max-width: 800px) {
        .phone {width: calc(100%);}
    }
</style>




<h3>Телефонная книга <?php echo $this->user['login']; ?></h3><hr>

<div id="phoneBook" style="position:relative;">
    <div style="text-align:left;">
        <input type="text" v-model="search" style="width:50%;" placeholder="Поиск: почта, имя, фамилия">
         | Всего: {{ filterPhones.length }}
    </div>
    <button style="position:absolute; right:0; top:0;" type="button" class="btn btn-success" v-on:click="editEntry()">Новая запись</button>
    <hr>

    <div v-for="phone in filterPhones" class="phone">
        <div style="float:left; width:40%;">
            Фото
        </div>
        <div style="float:left; width:60%; text-align:left; position:relative;">
            <table width="99%">
                <tr>
                    <td>Имя: </td>
                    <td align="right">{{ phone.name }}</td>
                </tr>
                <tr>
                    <td>Фамилия: </td>
                    <td align="right">{{ phone.last_name }}</td>
                </tr>
                <tr>
                    <td>Почта: </td>
                    <td align="right">{{ phone.email }}</td>
                </tr>
                <tr>
                    <td>Телефон: </td>
                    <td align="right">{{ phone.phone }}</td>
                </tr>
            </table>
        </div>
        <div style="clear:both;"></div>
        <hr style="margin:2px 0 4px 0;">
        <button type="button" class="btn btn-primary" v-on:click="editEntry(phone.id)">Редактировать</button>
        <button type="button" class="btn btn-danger" v-on:click="deleteEntry(phone.id)">Удалить</button>
    </div>
</div>
<div style="clear:both;"></div>




<script>
// const hilightTable = (color = '#eee') => {$(".phone:odd").css("background", color)};
var app = new Vue({
    el: '#phoneBook',
    data: {
        phones: <?php echo json_encode($phones, JSON_UNESCAPED_UNICODE); ?>,
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
                fetch('/phones?delete=' + this.phones[phonesArrId].id);
                this.phones.splice(phonesArrId, 1);
            }
        },
        editEntry(id = -1) {
            $("#phoneBook").hide();
            appEdit.phone = id > -1 ? this.phones[app.findById(id)] : {id: -1};
            $("#editTable").show();
        }
    },
    // updated: function() {
    //     this.$nextTick(hilightTable())
    // }
});
// hilightTable();
</script>






<div id="editTable" style="display: none">
    <div style="float:left; width:40%;">
        Фото
        <hr style="margin:2px 0 4px 0;">
        <button type="button" class="btn btn-success" v-on:click="loadPhoto()">Загрузить</button>
        <button type="button" class="btn btn-danger" v-on:click="removePhoto()">Удалить</button>
    </div>
    <div style="float:left; width:60%; text-align:left; position:relative;">
        <table width="99%">
            <tr>
                <td>Имя: </td>
                <td align="right">
                    <input type="text" v-model="phone.name">
                </td>
            </tr>
            <tr>
                <td>Фамилия: </td>
                <td align="right">
                    <input type="text" v-model="phone.last_name">
                </td>
            </tr>
            <tr>
                <td>Почта: </td>
                <td align="right">
                    <input type="text" v-model="phone.email">
                </td>
            </tr>
            <tr>
                <td>Телефон: </td>
                <td align="right">
                    <input type="text" v-model="phone.phone">
                </td>
            </tr>
        </table>
    </div>
    <div style="clear:both;"></div>
    <hr style="margin:2px 0 4px 0;">
    <button type="button" class="btn btn-secondary" v-on:click="back()">Назад</button>
    <button type="button" class="btn btn-success" v-on:click="save()">Сохранить</button>
</div>


<script>
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
                        alert('Запись сохранена');
                    }
                    else alert('Ошибка сохранения!\n' + decodeURI(text));
                });
        },
        newEntry() {
            fetch('/phones?newEntry=new&vals=' + JSON.stringify(this.phone))
                .then(response => response.text())
                .then(text => {
                    if (text == 'ok') {
                        this.back();
                        alert('Новая запись сохранена');
                    }
                    else alert('Ошибка сохранения!');
                });
        }
    }
});
</script>
