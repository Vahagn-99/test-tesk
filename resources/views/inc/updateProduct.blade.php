=<form id="update_product">
    @csrf
    <div class="prod">
        <div class="d-flex justify-content-between">
            <h3>Изменить продукт</h3>
            <a href="#" id="close_update"><i class="fas fa-times"></i></a>
        </div>
        <div class="form-group">
            <label for="articul" id="">Артикул</label>
            <input type="text" class="form-control" id="update_article" name="articul" value="">
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="update_name" name="name" value="">
        </div>
        <div class="form-group">
            <label for="status">Статус</label>
            <select class="form-control" id="update_status" name="status" value="">
                <option value="1">Доступен</option>
                <option value="0">Не доступен</option>
            </select>
        </div>
        <h5>Атрибуты </h5>
        <div class="">
            <div id="update_newRow"></div>
        </div>
        <div>
            <a id="update_addRow" class="text-primery fs-1" style="border-bottom:1px dotted blue">+ Добавить атрибут</a>
        </div>
        <button type="submit" class="btn btn-md px-5 my-4" id="save_product">Добавить</button>
    </div>
</form>
