<div>




    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Users</h2>
            <p class="text-muted">Manage user accounts.</p>
        </div>
        <div class="d-flex gap-2">
            <select wire:model.live="role" class="form-select" style="width: auto;">
                <option value="">All Roles</option>
                <option value="student">Student</option>
                <option value="owner">Owner</option>
                <option value="admin">Admin</option>
            </select>

            <div class="input-group" style="width: 300px;">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="Search users...">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
            </div>
        </div>
    </div>



    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color: rgb(185, 42, 42)">{{ session('error') }}</p>
    @endif

    <!-- Users List -->
    <div class="dashboard-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone Number</th>
                        <th>Joined</th>
                        <th>Apartments Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>


                            @switch($user->role)
                                @case('student')
                                    <td><span class="badge bg-info bg-opacity-10 text-info">Student</span></td>
                                @break

                                @case('owner')
                                    <td><span class="badge bg-warning bg-opacity-10 text-warning">Owner</span></td>
                                @break

                                @case('admin')
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger">Admin</span></td>
                                @break
                            @endswitch


                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>



                            @if ($user->role == 'owner')
                                @php

                                    $num = $user->apartments->count();

                                @endphp
                                <td>
                                    {{ $num }}

                                </td>
                            @else
                                <td>-</td>
                            @endif




                            <td>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    class="d-inline delete-form">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>


                            </td>
                        </tr>


                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No Users yet.
                                </td>
                            </tr>
                        @endforelse



                    </tbody>

                </table>

            </div>
        </div>


        <div class="d-flex justify-content-center mt-4"> 
            {{ $users->links() }}
        </div>



    </div>
