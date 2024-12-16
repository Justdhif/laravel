@extends('admin.layout.sidebar')

@section('title', 'dashboard.admin')

@section('content')
    <header class="header">
        <i class="fa-solid fa-bars" id="open" style="font-size: 25px"></i>
        <h1> Dashboard</h1>
        <div class="user" style="display: flex; align-items: center; gap: 10px">
            <h3>Welcome!!!</h3>
            <img src="{{ asset('storage/' . Auth::user()->profile_pic) }}" alt="" id="profile">
            <div class="detail_user">
                <h3 class="box">{{ Auth::user()->name }}</h3>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="box logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="total_content">
            <div class="total_body">
                <h3>Order</h3>
                <p>{{ $totalTransactions }}</p>
                <h3 id="icon"><i class="fa-solid fa-money-bill-wheat"></i></h3>
            </div>

            <div class="total_body terjual">
                <h3>Sold</h3>
                <p>{{ $totalStockSold }}</p>
                <h3 id="icon"><i class="fa-solid fa-cart-shopping"></i> </h3>
            </div>

            <div class="total_body menu">
                <h3>Menu</h3>
                <p>{{ $totalMenus }}</p>
                <h3 id="icon"><i class="fa-solid fa-bowl-food"></i></h3>
            </div>

            <div class="total_body voucher">
                <h3>Voucher</h3>
                <p>{{ $totalVouchers }}</p>
                <h3 id="icon"><i class="fa-solid fa-ticket"></i></h3>
            </div>
        </div>

        <div class="chart-container" style="position: relative; height: 400px; width: 100%; margin-top: 30px;">
            <canvas id="salesChart"></canvas>
            <div id="no-sales-message" style="display: none; text-align: center; color: gray; margin-top: 150px; font-size: 18px;">
                <p>Tidak ada penjualan untuk bulan tertentu.</p>
            </div>
        </div>

        <div class="data_user">
            <div class="data_content admin">
                <h3 class="title">Admin</h3>
                @foreach ($admins as $admin)
                    <div class="data_box">
                        <h3>{{ $loop->iteration }}. {{ $admin->name }}</h3>
                    </div>
                @endforeach
            </div>
            <div class="data_content pembeli">
                <h3 class="title">Pembeli</h3>
                @if ($customers->isEmpty())
                    <div class="empty">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>Tidak ada pembeli</h3>
                    </div>
                @else
                    @foreach ($customers as $customer)
                        <div class="data_box">
                            <h3>{{ $loop->iteration }}. {{ $customer->name }} ( {{ $customer->email }} )</h3>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="category_box">
            <h3 style="margin-bottom: 10px">Tambah Kategori</h3>
            <form action="{{ route('category.submit') }}" method="POST" class="formCategory">
                @csrf
                <input type="text" name="category_name" id="category_name" placeholder="Input category name">
                <button type="submit">Submit</button>
            </form>

            <div class="category_content">
                @if ($categories->isEmpty())
                    <div class="empty">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>Tidak ada kategori</h3>
                    </div>
                @else
                    @foreach ($categories as $category)
                        <div class="category_container">
                            <h3>{{ $category->category_name }}</h3>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <h2 style="margin: 30px 0 10px">Data Menu</h2>
        <a href="{{ route('admin.menus.create') }}" class="button">Tambah Menu Baru</a>

        <div class="table">
            <div class="head">
                <div class="box">
                    <h3>Gambar</h3>
                </div>
                <div class="box category">
                    <h3>Kategori</h3>
                </div>
                <div class="box">
                    <h3>Nama</h3>
                </div>
                <div class="box">
                    <h3>Deskripsi</h3>
                </div>
                <div class="box">
                    <h3>Harga</h3>
                </div>
                <div class="box">
                    <h3>Stok</h3>
                </div>
                <div class="box">
                    <h3>Terjual</h3>
                </div>
                <div class="box action">
                    <h3>Aksi</h3>
                </div>
            </div>
            @if ($menus->isEmpty())
                <div class="menu_data">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h3>Tidak ada menu</h3>
                </div>
            @else
                @foreach($menus as $menu)
                    <div class="body_table" style="background-color: @if($menu->stock > 0) #ccffcc @else #ffcccc @endif;">
                        <div class="box">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu" style="width: 100px; height: 100px; object-fit: cover; border-radius: 100%; border: 2px solid var(--main-color);">
                            @else
                                <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default" style="width: 100px; height: auto;">
                            @endif
                        </div>
                        <div class="box category">
                            <h3>{{ $menu->category->category_name ?? 'Tidak ada Kategori' }}</h3>
                        </div>
                        <div class="box">
                            <a href="{{ route('menu.show', $menu->id) }}"><h3>{{ $menu->name }}</h3></a>
                        </div>
                        <div class="box">
                            <h3>{{ $menu->description }}</h3>
                        </div>
                        <div class="box">
                            <h3>{{ $menu->price }}</h3>
                        </div>
                        <div class="box">
                            @if($menu->stock > 0)
                                <h3>{{ $menu->stock }}</h3>
                            @else
                                <h3 style="color: red;">Stok Habis</h3>
                            @endif
                        </div>
                        <div class="box">
                            <h3>{{ $menu->sold }}</h3>
                        </div>
                        <div class="box action">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="voucher_content">
            <form action="{{ route('admin.vouchers.store') }}" method="POST" class="box voucherForm">
                @csrf
                <h3 style="margin-bottom: 10px;">Tambah Voucher</h3>
                <div class="input_group">
                    <label for="voucher_code" class="form-label">Code</label>
                    <input type="text" class="form-control" name="voucher_code" required>
                </div>
                <div class="input_group">
                    <label for="discount" class="form-label">Diskon (%)</label>
                    <input type="number" class="form-control" name="discount" min="1" max="100" required>
                </div>
                <div class="input_group">
                    <label for="expiry_date" class="form-label">Expired</label>
                    <input type="date" class="form-control" name="expiry_date" required>
                </div>
                <div class="input_group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="general">General (Berlaku untuk semua menu)</option>
                        <option value="specific">Specific (Berlaku untuk menu tertentu)</option>
                    </select>
                </div>
                <div class="input_group" id="menu-selection" style="display: none;">
                    <label for="menu_id" class="form-label" style="margin-bottom: 10px;">Choose</label>
                    <select name="menu_id" class="form-control">
                        <option value="" disabled selected>Tidak ada menu</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit">Simpan</button>
            </form>
            <div class="box data_voucher">
                <h3 style="margin-bottom: 10px">Voucher</h3>
                @if ($vouchers->isEmpty())
                    <div class="empty">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>No vouchers available</h3>
                    </div>
                @else
                    <div class="voucher_box">
                        <div class="voucher_item" id="top">
                            <h3>#</h3>
                            <h3>code</h3>
                            <h3>discount</h3>
                            <h3>expired</h3>
                            <h3>action</h3>
                        </div>
                        <div class="voucher_item" id="top">
                            <h3>#</h3>
                            <h3>code</h3>
                            <h3>discount</h3>
                            <h3>expired</h3>
                            <h3>action</h3>
                        </div>
                        @foreach($vouchers->take(10) as $voucher)
                            <div class="voucher_item">
                                <h3>{{ $loop->iteration }}</h3>
                                <h3>{{ $voucher->voucher_code }}</h3>
                                <h3>{{ $voucher->discount }}%</h3>
                                <h3>{{ $voucher->expiry_date }}</h3>
                                <div class="action">
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- To-Do List Section -->
        <div class="todo_list">
            <h3 style="margin-bottom: 10px">To-Do List</h3>
            <form action="{{ route('todo.submit') }}" method="POST" class="formTodo">
                @csrf
                <input type="text" name="task_name" id="task_name" placeholder="Input new task" required>
                <button type="submit">Add Task</button>
            </form>

            <div class="todo_content">
                @if ($todos->isEmpty())
                    <div class="empty">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>No tasks available</h3>
                    </div>
                @else
                    @foreach($todos as $todo)
                        <div class="todo_item" style="background-color: {{ $todo->status === 'completed' ? '#ccffcc' : '#ffcccb' }}">
                            <div class="todo_header">
                                <h3 style="font-size: 20px">{{ $loop->iteration }}</h3>
                                @if ($todo->admin->profile_picture)
                                    <img src="{{ asset('storage/' . $todo->admin->profile_picture) }}" alt="Foto Profil"
                                        style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/profile/default-profile.png') }}" alt="Default Profile"
                                        style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                @endif

                                <div class="admin_info">
                                    <h3>{{ $todo->admin->name }}</h3>
                                    <p>{{  $todo->created_at }}</p>
                                </div>
                            </div>
                            <h3 style="margin: 10px 0 0">Task : {{ $todo->task_name }}</h3>
                            <p style="margin: 0 0 10px">Status: {{ ucfirst($todo->status) }}</p>

                            <div class="btn_content">
                                @if($todo->status === 'progress')
                                    <form action="{{ route('todos.complete', $todo->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-complete">Done</button>
                                    </form>
                                @endif
                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


        <h3 style="margin: 30px 0 0">Transaction History</h3>
        <div class="trasanction_container">
            @if ($transactions->isEmpty())
                <div class="menu_data">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <h3>Tidak ada transaksi</h3>
                </div>
            @else
                @foreach ($transactions->take(4) as $transaction)
                    <div class="transaction_box">
                        <div class="icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h3>ID Transaksi: {{ $transaction->id }}</h3>
                        <h3>Nama  : {{ $transaction->user->name }}</h3>
                        <h3>{{ $transaction->user->email }}</h3>
                        <h3>{{ $transaction->created_at }}</h3>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="detail">More</a>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="most_fitur">
            <div class="box_content admin_best">
                <h3 style="margin-bottom: 15px;">Admin Terbaik</h3>
                @if ($topUser)
                    @if ($topUser->profile_picture)
                        <img src="{{ asset('storage/' . $topUser->profile_picture) }}"
                            alt="Foto Profil"
                            style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                    @else
                        <img src="{{ asset('images/profile/default-profile.png') }}"
                            alt="Default Profile"
                            style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                    @endif
                    <h3>{{ $topUser->name }}</h3>
                    <p>Task Completed: {{ $topUser->todos_count }}</p>
                @else
                    <div class="menu_data">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>Tidak ada menu terbaik</h3>
                    </div>
                @endif
            </div>
            <div class="box_content menu_best">
                <h3 style="margin-bottom: 15px;">Menu Terbaik</h3>
                @if ($topSellingMenus->isEmpty())
                    <div class="menu_data">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <h3>Tidak ada menu terjual</h3>
                    </div>
                @else
                    <div class="grid_menu">
                        @foreach($topSellingMenus->take(5) as $menu)
                            <div class="box">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu" style="width: 100px; height: 100px; object-fit: cover; border-radius: 100%; border: 2px solid var(--text-color); margin-bottom: 10px;">
                                @else
                                    <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default" style="width: 100px; height: auto; margin-bottom: 10px;">
                                @endif
                                <h3>{{ $menu->name }}</h3>
                                <p>Sold : {{ $menu->sold }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = @json($salesData); // Data penjualan
        const months = @json($months); // Nama bulan

        const allZero = salesData.every(value => value === 0);

        if (allZero) {
            document.getElementById('salesChart').style.display = 'none';
            document.getElementById('no-sales-message').style.display = 'block';
        } else {
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Gradien warna
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(75, 192, 192, 1)');
            gradient.addColorStop(1, 'rgba(153, 102, 255, 0.7)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Penjualan',
                        data: salesData,
                        backgroundColor: gradient,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.8)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuad'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleFont: { size: 16, weight: 'bold' },
                            bodyFont: { size: 14 },
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw || 0;
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.3)'
                            },
                            title: {
                                display: true,
                                text: 'Total Penjualan (Rp)',
                                color: '#333',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    elements: {
                        bar: {
                            borderRadius: 8, // Rounded corners
                            hoverBorderWidth: 3,
                        }
                    }
                }
            });
        }

        const profile = document.getElementById('profile');
        const detailUser = document.querySelector('.detail_user');

        profile.addEventListener('click', function() {
            detailUser.classList.toggle('show');
        });

        document.getElementById('type').addEventListener('change', function() {
            const menuSelection = document.getElementById('menu-selection');
            menuSelection.style.display = this.value === 'specific' ? 'block' : 'none';
        });
    </script>
@endsection
