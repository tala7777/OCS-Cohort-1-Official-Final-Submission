<div>
    <div class="container custom-width-container mt-5 pt-5 pb-5">
        <div class="row pt-4">

            <div class="col-lg-3 mb-4">
                <div class="sidebar-filters shadow-sm">
                    <h4 class="mb-4">Filter Results</h4>

                    <div class="filter-group">
                        <div class="filter-title">Search</div>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="bi bi-search text-muted"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="form-control border-start-0 ps-0" placeholder="Apartment Or Location">
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-title">University</div>
                        <select wire:model.live="university_id" class="form-select">
                            <option value="">All Universities</option>
                            @foreach ($universities as $uni)
                                <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <div class="filter-title">Area (sqm)</div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" wire:model.live="minArea" class="form-control" placeholder="Min">
                            <span class="text-muted">-</span>
                            <input type="number" wire:model.live="maxArea" class="form-control" placeholder="Max">
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-title">Gender</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="gender" type="radio" wire:model.live="gender"
                                value="" id="genderall">
                            <label class="form-check-label" for="genderall">All
                                ({{ \App\Models\Apartment::count() }})</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="gender" type="radio" wire:model.live="gender"
                                value="male" id="male">
                            <label class="form-check-label" for="male">Male
                                ({{ \App\Models\Apartment::where('allowed_gender', 'male')->count() }})</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="gender" type="radio" wire:model.live="gender"
                                value="female" id="female">
                            <label class="form-check-label" for="female">Female
                                ({{ \App\Models\Apartment::where('allowed_gender', 'female')->count() }})</label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-title">Rent Type</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="rent" type="radio" wire:model.live="rentType"
                                value="" id="rentall">
                            <label class="form-check-label" for="rentall">All
                                ({{ \App\Models\Apartment::count() }})</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="rent" type="radio" wire:model.live="rentType"
                                value="whole" id="rentWhole">
                            <label class="form-check-label" for="rentWhole">Full Apartment
                                ({{ \App\Models\Apartment::where('rent_type', 'whole')->count() }})</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="rent" type="radio" wire:model.live="rentType"
                                value="rooms" id="rentRooms">
                            <label class="form-check-label" for="rentRooms">Rooms
                                ({{ \App\Models\Apartment::where('rent_type', 'rooms')->count() }})</label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <div class="filter-title">Price Range ($)</div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" wire:model.live="minPrice" class="form-control" placeholder="Min">
                            <span class="text-muted">-</span>
                            <input type="number" wire:model.live="maxPrice" class="form-control" placeholder="Max">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 fw-bold mb-0">Available Apartments</h2>
                    <span class="text-muted">Showing {{ $apartments->count() }} Results</span>
                </div>

                @forelse($apartments as $apart)
                    <div class="apartment-card-vertical" wire:key="apt-{{ $apart->id }}">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if ($apart->images->first())
                                    <img src="{{ asset('storage/' . $apart->images->first()->image_path) }}"
                                        alt="{{ $apart->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                        style="min-height: 220px;">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h3 class="apt-title">{{ $apart->name }}</h3>
                                        <span class="apt-price">${{ $apart->price }}<small
                                                class="text-muted fs-6 fw-normal">/{{ $apart->rent_type == 'whole' ? 'mo' : 'room' }}</small></span>
                                    </div>

                                    <div class="apt-meta">
                                        <span><i class="bi bi-geo-alt-fill"></i>{{ $apart->location }}</span>
                                        <span><i
                                                class="bi bi-mortarboard-fill"></i>{{ $apart->university->name }}</span>
                                        <span><i class="bi bi-aspect-ratio"></i>{{ $apart->area }} m²</span>
                                    </div>



                                    <div class="apt-meta ">

                                        @if ($apart->allowed_gender == 'male')

                                            <span><i class="bi bi-gender-male"></i></span>
                                            {{ $apart->allowed_gender }}

                                        @elseif($apart->allowed_gender == 'female')

                                            <span><i class="bi bi-gender-female"></i></span>
                                            {{ $apart->allowed_gender }}

                                        @endif


                                    </div>




                                    <p class="apt-info">{{ Str::limit($apart->description, 160) }}</p>

                                    <div class="mt-auto">
                                        <a href="{{ route('apartments_d', $apart->id) }}"
                                            class="btn btn-outline-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-house-exclamation fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">No apartments match your filters.</p>
                    </div>
                @endforelse

                <div class="mt-4 d-flex justify-content-center">
                    {{ $apartments->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
