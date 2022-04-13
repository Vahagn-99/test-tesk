@extends('layouts.app')
@section('content')
    <div class="wrapper">

        <nav class="d-flex justify-content-between main-header align-items-center navbar-white navbar-light">

            <div class="px-5 py-3">
                <span>Продукты </span>
            </div>
            <div class="px-5 py-3">
                <a href="#" class="d-block">{{ Auth::user()->name ?? ' name for user' }}</a>
            </div>

        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="logo py-4 px-2">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" style="width:100%;height:auto">
                        </div>
                        <div class="page_title px-4 py-1">
                            <p>
                                Enterprise
                                Resource
                                Planning
                            </p>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="../widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Продукты
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class=" content-wrapper">
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div class="card  p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Артикул</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Атрибуты</th>
                                    </tr>
                                </thead>
                                <tbody id="get-Products">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn  btn-md float-right m-2">добавить</button>

                        <div class="product m-2 mt-5 p-3">
                            <form>
                                <div class="add_prod">
                                    <h3>Добавить продукт</h3>
                                    <div class="form-group">
                                        <label for="articul">Артикул</label>
                                        <input type="password" class="form-control" id="articul" name="articul"
                                            placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Название</label>
                                        <input type="password" class="form-control" id="name" name="name"
                                            placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Статус</label>
                                        <select class="form-control" id="status" name="status">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                    <h5>Атрибуты </h5>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group pr-3">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div id="inputFormRow">
                                            <div class="input-group mb-3">
                                                <input type="text" name="title[]" class="form-control m-input"
                                                    placeholder="Enter title" autocomplete="off">
                                                <input type="text" name="title[]" class="form-control m-input"
                                                    placeholder="Enter title" autocomplete="off">
                                                <div class="input-group-append">
                                                    <a id="removeRow">Delete</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="newRow"></div>
                                        <a id="addRow" class="text-primery">+Add Row</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    @push('custom-js')
        <script>
            $(document).ready(function() {
                function queryAjax(url, method, resolve, data = null, before = null, after = null) {
                    // e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method: method,
                        data: data,
                        beforeSend: () => {
                            if (before)
                                before();
                        },
                        complete: () => {
                            if (after)
                                after();
                        },
                        success: function(result) {
                            resolve(result);
                        },
                        error: function(error) {
                            console.log(error);
                        }()
                    });
                }
                const getProducts = queryAjax("{{ route('products.index') }}", 'GET', (response) => {
                    function objectParse(object, list = []) {

                        for (const [key, value] of Object.entries(object)) {
                            list.push(`${key}:${value}`);
                        }
                        console.log(list.toString().replace(',', '\n'));
                        return list.toString().replaceAll(',', "<br>");
                    };
                    console.log(response.data);
                    response.data.forEach(product => {

                        $('#get-Products').append(
                            `<tr >
                                        <td>${product.article}</td>
                                        <td>${product.name}</td>
                                        <td>${product.status}</td>
                                        <td class="h6">${objectParse(product.data)}</td>
                                        </tr>`

                        )
                    })

                })
            })
        </script>
    @endpush
@endsection
