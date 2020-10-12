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
    @media (max-width: 1000px) {
        .phone {width: calc(100%);}
    }
</style>




<h3>Телефонная книга <?php echo $this->user['login']; ?></h3><hr>

<div id="phoneBook" style="position:relative;">
    <div style="text-align:left;">
        <input type="text" v-model="search" style="width:50%;" placeholder="Поиск: имя, почта">
         | Всего: {{ filterPhones.length }}
    </div>
    <button style="position:absolute; right:0; top:0; cursor:pointer;" type="button" class="btn btn-success" onclick="alert('new')">Новая запись</button>
    <hr>

    <div v-for="phone in filterPhones" class="phone">
        <div style="float:left; width:40%;">
            Photo
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
        <button type="button" class="btn btn-primary" onclick="alert('edit')">Редактировать</button>
        <button type="button" class="btn btn-danger" onclick="alert('delete')">Удалить</button>
    </div>
</div>




<script>
// const hilightTable = (color = '#eee') => {$(".phone:odd").css("background", color)};
var phones = <?php echo json_encode($phones, JSON_UNESCAPED_UNICODE); ?>;
var app = new Vue({
    el: '#phoneBook',
    data: {
        phones: <?php echo json_encode($phones, JSON_UNESCAPED_UNICODE); ?>,
        search: ''
    },
    computed: {
        filterPhones() {
            return this.phones.filter(phone =>
                phone.name.indexOf(this.search) == 0
                || phone.email.indexOf(this.search) == 0
            )
        }
    },
    // updated: function() {
    //     this.$nextTick(hilightTable())
    // }
});
// hilightTable();
</script>
