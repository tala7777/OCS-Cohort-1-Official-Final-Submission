<div>




    <div class="dashboard-card mb-4 p-3">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                        placeholder="Search by name...">
                </div>
            </div>

            <div class="col-md-3">
                <select wire:model.live="university_id" class="form-select">
                    <option value="">All Universities</option>
                    @foreach ($universities as $uni)
                        <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <select wire:model.live="gender" class="form-select">
                    <option value="">All Genders</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="col-md-3">
                <select wire:model.live="sort" class="form-select">
                    <option value="">Sort by Price</option>
                    <option value="min-max">Price: Low to High</option>
                    <option value="max-min">Price: High to Low</option>
                </select>
            </div>
        </div>
    </div>



    <!-- Apartments List -->
    <div class="dashboard-card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Nearby University</th>
                        <th>Gender</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($apartments as $apart)
                        @php
                            // Find the image marked as 'is_main'
                            $mainImage = $apart->images->where('is_main', true)->first();
                            // Fallback to the first image if no 'is_main' is found
                            $displayImage = $mainImage ?? $apart->images->first();
                        @endphp


                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $displayImage ? asset('storage/' . $displayImage->image_path) : asset('images/sample1.jpg') }}"
                                        class="rounded" width="40" height="40" style="object-fit: cover;">
                                    <span class="fw-bold small">{{ $apart->name }}</span>
                                </div>
                            </td>
                            <td>{{ $apart->owner->name }}</td>
                            <td>{{ $apart->location }}</td>
                            <td>{{ $apart->university->name }}</td>
                            <td><span class="badge bg-secondary">{{ $apart->allowed_gender }}</span></td>
                            <td>{{ number_format($apart->price, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-light text-primary"><a href="{{ route('apartments_d', $apart->id) }}"><i class="bi bi-eye"></i></a></button>




                                <form action="{{ route('apartments.destroy', $apart->id) }}" method="POST"
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
                                No apartments yet.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>




    <div class="d-flex justify-content-center mt-4">
        {{ $apartments->links() }}
    </div>






</div>
