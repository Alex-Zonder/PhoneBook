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
            <img :src="phone.image ? '?photo=' + phone.image : '/images/default_avatar.png'" width="40%">
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




<div id="editTable" style="display: none">
    <div style="float:left; width:40%;">
        <img :src="image != '' ? image : (phone.image ? '?photo=' + phone.image : '/images/default_avatar.png')" width="50%" />
        <hr style="margin:2px 0 4px 0;">
        <input type="file" id="file-input" style="display: none;" v-on:change="onFileChange" />
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
'use strict'
var phoneBook = <?php echo json_encode($phones, JSON_UNESCAPED_UNICODE); ?>;
</script>
<script src="js/phoneBook.js"></script>
