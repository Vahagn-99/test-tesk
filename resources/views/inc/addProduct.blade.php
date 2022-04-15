<form id="add_product">
    @csrf
    <div class="d-flex justify-content-between">
        <h3>Добавить продукт</h3>
        <a href="#" id="close"><i class="fas fa-times"></i></a>
    </div>
    <div class="prod">

        <div class="form-group">
            <label for="articul" id="">Артикул</label>
            <input type="text" class="form-control" id="article" name="articul">
        </div>
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="status">Статус</label>
            <select class="form-control" id="status" name="status">
                <option value="1">Доступен</option>
                <option value="0">Не доступен</option>
            </select>
        </div>
        <h5>Атрибуты </h5>
        <div class="">
            <div id="newRow"></div>
        </div>
        <div>
            <a id="addRow" class="text-primery fs-1" style="border-bottom:1px dotted blue">+Добавить атрибут</a>
        </div>
        <button type="submit" class="btn btn-md px-5 my-4" id="add">Добавить</button>
    </div>
</form>
