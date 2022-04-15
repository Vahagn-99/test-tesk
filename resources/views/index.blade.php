@extends('layouts.app')
@section('content')
    <div class="wrapper">

        <nav class="d-flex justify-content-between main-header align-items-center navbar-white navbar-light">

            <div class="px-5 py-3 sel">
                <span >Продукты </span>
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
                    <div class="col-md-7 mt-2">
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
                    <div class="col-md-5">
                        <button class="btn btn-md float-right m-2 px-5" id="add_btn">Добавить</button>

                        <div class="product m-2 mt-5 p-3 add_prod">
                            @include('inc.addProduct')
                        </div>
                        <div id="show_product" class="product m-2 mt-5 p-3 show_product">
                            @include('inc.showProduct')
                        </div>

                    </div>
                </div>
            </section>
        </div>
        @push('custom-js')
            <script>
                $(document).ready(function() {
                    function queryAjax(
                        url,
                        method,
                        resolve,
                        data = null,
                        before = null,
                        after = null
                    ) {
                        // e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
                            },
                        });
                        $.ajax({
                            url: url,
                            method: method,
                            data: data,
                            beforeSend: () => {
                                if (before) before();
                            },
                            complete: () => {
                                if (after) after();
                            },
                            success: function(result) {
                                resolve(result);
                            },
                            error: (function(error) {
                                console.log(error);
                            })(),
                        });
                    }

                    function objectParse(object, list = []) {
                        if (!object) {
                            return "no property";
                        }
                        for (const [key, value] of Object.entries(object)) {
                            list.push(`${key}:${value}`);
                        }
                        return list.toString().replaceAll(",", "<br>");
                    }
                    // show Product method
                    let showProduct = () => {
                        $("#show_product").hide();
                        $('.product_item').on('click', function() {
                            let id = $(this).attr('value');
                            console.log(id);
                            queryAjax(`api/products/${id}`, "GET", (response) => {
                                $('#articul_id').text(response.data.article);
                                $('#name_id').text(response.data.name);
                                $('#name_title').text(response.data.name);
                                $('#status_id').text(response.data.status);
                                let data = objectParse(response.data.data);
                                $('#data_id').html(data);
                                $("#show_product").show();
                                $('#add_btn').hide();
                                $(".add_prod").removeClass("show");

                                console.log(response);
                            })
                        })
                        $("#close_show").on("click", function() {
                            $("#show_product").hide();
                            $('#add_btn').show();
                        });
                    }
                    //get all products
                    let elemtTr = '';
                    let getProducts = () => {
                        queryAjax("{{ route('products.index') }}", 'GET', (response) => {
                            response.data.forEach(product => {
                                elemtTr += `<tr class="product_item"`
                                elemtTr += ` role = "button"`
                                elemtTr += ` value = "${product.id}" >`
                                elemtTr += ` <td>${product.article}</td>`
                                elemtTr += ` <td>${product.name}</td>`
                                elemtTr += ` <td>${product.status}</td>`
                                elemtTr += ` <td class="h6">${objectParse(product.data)}</td>`
                                elemtTr += ` </tr>`;
                            })
                            $('#get-Products').html(elemtTr)
                            showProduct()
                        })

                    }
                    getProducts();
                    //add new product
                    $('#add_product').on('submit', (e) => {
                        e.preventDefault();

                        let keys = []; // keys for optional rows
                        let values = []; // values for optional rows
                        let result = {};

                        $("input[name='key[]']").each(function() {
                            return keys.push(this.value);
                        });
                        $("input[name='value[]']").each(function() {
                            return values.push(this.value);
                        });
                        // add optional rows to object
                        for (i = 0; i < keys.length; i++) {
                            if (keys[i] !== "" && values[i] !== "")
                                result[keys[i]] = values[i];
                        }

                        queryAjax("{{ route('products.store') }}", "POST", (response) => {}, {
                            "_token": "{{ csrf_token() }}",
                            article: $("#article").val(),
                            name: $("#name").val(),
                            status: $("#status").val(),
                            data: result,
                        }, () => {
                            $('#get-Products').html(elemtTr = '');
                            console.log('reset');
                        }, () => {
                            getProducts();
                        })
                    })



                })
            </script>
        @endpush
    @endsection
