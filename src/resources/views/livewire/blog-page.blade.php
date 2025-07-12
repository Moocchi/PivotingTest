<main>
    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade"
            style="background-image: url(front/assets/img/page-title-bg.jpg);">
            <div class="container position-relative">
                <h1>Blog</h1>
                <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda
                    numquam molestias.</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li class="current">Blog</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        
  

<div class="container py-5">
    <div class="row gy-4">
        @foreach ($blogs as $blog)
            <div class="col-lg-4">
                <article class="card h-100 shadow-sm border-0">

                    <!-- Gambar -->
                    <div class="ratio ratio-16x9">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                            class="object-fit-cover w-100 h-100 rounded-top">
                    </div>

                    <!-- Isi -->
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title text-truncate" title="{{ $blog->title }}">
                            <a href="#" class="text-decoration-none text-dark">{{ $blog->title }}</a>
                        </h5>

                        <div class="meta mb-2 small text-muted">
                            <div><i class="bi bi-person"></i> Author ID: {{ $blog->author_id }}</div>
                            <div><i class="bi bi-clock"></i>
                                <time datetime="{{ $blog->published_at->toDateString() }}">
                                    {{ $blog->published_at->format('M j, Y') }}
                                </time>
                            </div>
                        </div>

                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($blog->description, 100) }}
                        </p>

                        <div class="mt-auto">
                            <a href="#" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</div>


    </main>
</main>