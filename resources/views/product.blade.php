@extends('base')

@section('content')
<div class="container my-4 px-3">
    <div class="row">
        <div class="col-12 col-md-4">

            <img src="/uploads/{{ $product->image_url }}" style="width: 100%" class="img-fluid" id="mainImg">

            <div class="row g-2 mt-2">
                <div class="col-3">
                    <img src="/uploads/{{ $product->image_url }}" style="width: 100%" class="gallery-imgs img-fluid">
                </div>

                @foreach ($product->images as $image)
                <div class="col-3">
                    <img src="/uploads/{{ $image->image_url }}" style="width: 100%" class="gallery-imgs img-fluid">
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-12 col-md-8">
            <h2 class="h4 fw-bold mt-4 mt-md-0">{{ $product->name }}</h2>

            <p class="text-muted">{{ $product->short_description }}</p>

            <div class="d-flex gap-1">
                <x-rating/>
            </div>

            <h4 class="fw-bold text-primary mt-2">Rs. {{ $product->price }}</h4>

            <div class="d-flex align-items-center gap-2 mt-3">
                <label for="quantity" class="form-label fw-semibold">Quantity : </label>
                <input type="number" name="quantity" id="quantity" value="1" class="form-control" style="max-width: 150px;">
            </div>

            <div class="d-flex gap-2 mt-4">
                <button id="btnCart" class="btn btn-primary d-flex align-items-center gap-2" data-product_id="{{ $product->id }}">
                    <span class="material-icons" style="font-size: 20px;">shopping_cart</span> Add to cart
                </button>

                <button id="btnWishlist" class="btn btn-danger d-flex align-items-center gap-2" data-product_id="{{ $product->id }}">
                    <span class="material-icons" style="font-size: 20px;">favorite</span> Wishlist
                </button>
            </div>

            <h4 class="fw-bold text-info h6 mt-4">Long Description</h4>

            <p class="text-muted">{{ $product->long_description }}</p>

            <div class="card" id="#reviewCard">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-primary">Reviews</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRvModal">Add Review</button>
                </div>

                <div class="card-body" id="reviewContainer">
                    @if (count($reviews) == 0)
                    <div class="alert alert-warning">No Reviews Found</div>
                    @endif

                    @foreach ($reviews as $review)
                    <div class="review mt-3 pt-3 border-top" data-own="{{ auth()->user()?->id == $review->user->id }}">
                        <h6 class="fw-semibold">{{ $review->user->name }}</h6>

                        <div class="d-flex">
                            <span class="material-icons {{ $review->rating >= 1 ? 'text-warning' : 'text-muted'}} h6">star</span>
                            <span class="material-icons {{ $review->rating >= 2 ? 'text-warning' : 'text-muted'}} h6">star</span>
                            <span class="material-icons {{ $review->rating >= 3 ? 'text-warning' : 'text-muted'}} h6">star</span>
                            <span class="material-icons {{ $review->rating >= 4 ? 'text-warning' : 'text-muted'}} h6">star</span>
                            <span class="material-icons {{ $review->rating >= 5 ? 'text-warning' : 'text-muted'}} h6">star</span>
                        </div>

                        <p class="text-muted">{{ $review->review }}</p>

                        @if ($review->user->id == auth()->user()?->id)
                        <button type="button" class="btn_edit_review btn btn-sm btn-warning" data-review="{{ $review->review }}" data-rating="{{ $review->rating }}">Edit</button>

                        <button type="button" class="btn-dlt-review btn btn-sm btn-danger" data-product_id="{{ $product->id }}">Delete</button>
                        @endif
                    </div>
                    @endforeach

                    <button class="btn btn-sm btn-dark mt-2" data-product_id="{{ $product->id }}" id="loadReviewBtn">Load More</button>
                    
                    <p style="display: none;" id="loadReviewLoader" class="mt-2">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createRvModal" tabindex="1" aria-labelledby="createRvModalLabel" aria-hidden="true">
        <form id="createRvForm" class="modal-dialog" data-product_id="{{ $product->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fw-bold text-primary">Your Review And Rating</p>
                    <button type="button" class="create-rv-modal-btns btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createRvFormRating" class="form-label">Rating</label>
                        <select id="createRvFormRating" class="form-select form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="createRvFormReview" class="form-label">Review</label>
                        <textarea id="createRvFormReview" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="create-rv-modal-btns btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" type="create-rv-modal-btns button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editRvModalLabel" aria-hidden="true">
        <form id="editRvForm" class="modal-dialog" data-product_id="{{ $product->id }}">            
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fw-bold text-primary">Your Review And Rating</p>
                    <button type="button" class="edit-rv-modal-option btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mb-3">
                        <label for="editRvModalRating" class="form-label">Rating</label>
                        <select id="editRvModalRating" class="form-select form-control">
                            <option class="edit-rv-modal-options" value="1">1</option>
                            <option class="edit-rv-modal-options" value="2">2</option>
                            <option class="edit-rv-modal-options" value="3">3</option>
                            <option class="edit-rv-modal-options" value="4">4</option>
                            <option class="edit-rv-modal-options" value="5" selected>5</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editRvModalReview" class="form-label">Review</label>
                        <textarea id="editRvModalReview" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="edit-rv-modal-option btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" type="button" class="edit-rv-modal-option btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $("#loadReviewBtn").click(async function() {

        $(this).hide()

        $("#loadReviewLoader").show()

        const product_id = $(this).data("product_id")

        const offset = $(".review").length

        const response = await fetch(`/products/${product_id}/reviews?offset=${offset}`, {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })

        if(response.status === 200)
        {
            const reviews = await response.json()

            let html = ""

            for(let i = 0; i < reviews.length; i++)
            {
                html += `<div class="review mt-3 pt-3 border-top">`

                html += `<h6 class="fw-semibold">${review.user.name}</h6>`

                html += `<div class="d-flex">`

                html += `<span class="material-icons ${review.rating >=1 ? 'text-warning' : 'text-muted'} h6">star</span>`

                html += `<span class="material-icons ${review.rating >=2 ? 'text-warning' : 'text-muted'} h6">star</span>`

                html += `<span class="material-icons ${review.rating >=3 ? 'text-warning' : 'text-muted'} h6">star</span>`

                html += `<span class="material-icons ${review.rating >=4 ? 'text-warning' : 'text-muted'} h6">star</span>`

                html += `<span class="material-icons ${review.rating >=5 ? 'text-warning' : 'text-muted'} h6">star</span>`

                html += `</div>`

                html += `<p class="text-muted">${review.review}</p>`

                html += `<button type="button" class="btn_edit_review btn btn-sm btn-warning" data-review="${review.review}" 
                        data-rating="${review.rating}">Edit</button>`

                html += `<button type="button" class="btn-dlt-review btn btn-sm btn-danger" data-product_id="${review.product_id}"
                        >Delete</button>`
            }

            if(reviews.length != 0) 
            {
                $(reviews.map(review => `
                
                    
                    
                        
                        <span class="material-icons ${review.rating >=2 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=3 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=4 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=5 ? 'text-warning' : 'text-muted'} h6">star</span>
                    </div>
                    
                    ${review.user.id === window.user?.id ? `<button type="button" class="btn_edit_review btn btn-sm btn-warning" data-review="${review.review}" data-rating="${review.rating}">Edit</button>
                    <button type="button" class="btn-dlt-review btn btn-sm btn-danger" data-product_id="${review.product_id}">Delete</button>` : ''}
                </div>
                `).join("")).insertBefore("#loadReviewBtn")

                $("#loadReviewLoader").hide()
                $("#loadReviewBtn").show()
            }
            else 
            {
                $("#loadReviewLoader").html("No More Review")
            }
        }
    })
    
    // $("#editRvForm").submit(async function(event) {

    //     event.preventDefault()
        
    //     $(".edit-rv-modal-btns").attr("disabled", true)

    //     const product_id = $(this).data("product_id")

    //     const rating = $("#editRvModalRating").val()

    //     const review = $("#editRvModalReview").val()

    //     const response = await fetch(`/products/${product_id}/reviews?_method=PATCH`, {
    //         method: "POST",
    //         headers: {
    //             "X-CSRF-TOKEN": "{{ csrf_token() }}",
    //             "Accept": "application/json",
    //             "Content-Type": "application/json"
    //         },
    //         body: JSON.stringify({
    //             rating,
    //             review
    //         })
    //     })

    //     if(response.status === 200)
    //     {
    //         $(`.review[data-own=1]`).get(0).remove()
    //         $("#editRvModalReview").val("")
    //         alert("Review updated. Review will be displayed after admin's approval")
    //         var editRvModal = bootstrap.Modal.getInstance(document.getElementById("editRvModal"))
    //         editRvModal.hide()
    //     }
    //     else 
    //     {
    //         console.log(await response.json());
    //         alert("Sorry, An unknonw error occur")
    //     }

    //     $(".edit-rv-modal-option").attr("disabled", false)
    // })

    $("#createRvForm").submit(async function(event) {
        event.preventDefault()

        $(".create-rv-modal-btns").attr("disabled", true)

        const product_id = $(this).data("product_id")

        const review = $("#createRvFormReview").val()

        const rating = $("#createRvFormRating").val()

        const response = await fetch(`/products/${product_id}/reviews`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                product_id,
                review,
                rating
            })
        })

        if (response.status == 201) 
        {
            alert("Review added successfully. Review will be displayed after admin's approval.")
        }
        else 
        {
            alert("Sorry, An unknown error occur")
        }

        var createReviewModal = bootstrap.Modal.getInstance(document.getElementById("createRvModal"))
        createReviewModal.hide()

        $(this).get(0).reset()

        $(".create-rv-modal-btns").attr("disabled", false)
    })

    $(".gallery-imgs").click(function() {
        $("#mainImg").attr("src", $(this).attr("src"))
    })

    $("#reviewContainer").on("click", ".btn_edit_review", async function() {
        $("#editReviewModal textarea").val($(this).data("review"))
        $(`#editReviewModal option[value=${$(this).data('rating')}]`).attr("selected", true)
        $(`#editReviewModal`).modal("show")
        $(`#editReviewModal form`).data("product_id", $(this).data('product_id'))
    })
    $("#editReviewModal form").submit(async function(event) {
        event.preventDefault()

        const response = await fetch(`/products/${$("#editReviewModal form").data("product_id")}/reviews?_method=PATCH`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                rating: $("#editReviewModal select").val(),
                review: $("#editReviewModal textarea").val()
            })
        })

        if(response.status === 200)
        {
            $("#editReviewModal").modal("hide")

            const res = await response.json()

            alert(res.success)

            $("#reviewCard").load(window.location.href + " #reviewContainer")
        }
    })

    $("#createReviewModal form").submit(function(event) {
        event.preventDefault()

        const response = await fetch(`/products/${$("#editReviewModal form").data("product_id")}/reviews?_method=PATCH`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                rating: $("#createReviewModal select").val(),
                review: $("#createReviewModal textarea").val()
            })
        })

        if(response.status === 200)
        {
            event.target.reset()

            const data = await response.json()

            alert(data.success)

            $("#createReviewModal").modal("show")
        }
    })

    $("#reviewContainer").on("click", "#loadMore", async function() {
        $(this).hide()

        $("#loadMoreLoader").show()

        const product_id = $(this).data("product_id")

        const offset = $(".review").length

        const response = await fetch(`/products/${product_id}/reviews?offset=${offset}`, {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })

        if (response.status == 200) 
        {
            const reviews = await response.json()

            if(reviews.length != 0) 
            {
                $(reviews.map(review => `
                <div class="review mt-3 pt-3 border-top" data-own="${review.user.id == window.user.id}">
                    <h6 class="fw-semibold">${review.user.name}</h6>
                    <div class="d-flex">
                        <span class="material-icons ${review.rating >=1 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=2 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=3 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=4 ? 'text-warning' : 'text-muted'} h6">star</span>
                        <span class="material-icons ${review.rating >=5 ? 'text-warning' : 'text-muted'} h6">star</span>
                    </div>
                    <p class="text-muted">${review.review}</p>
                    ${review.user.id === window.user.id ? `<button type="button" class="btn-et-review btn btn-sm btn-warning" data-review="${review.review}" data-rating="${review.rating}">Edit</button>
                    <button type="button" class="btn-dlt-review btn btn-sm btn-danger" data-product_id="${review.product_id}">Delete</button>` : ''}
                </div>
                `).join("")).insertBefore("#loadMore")
            }
        }
        else 
        {
            alert("Sorry, An unknown error occur")
            $(this).attr("disabled", false)
        }

        $("#loadMoreLoader").hide()
        $("#loadMore").show()
    })

    $("#reviewContainer").on("click", ".btn-et-review", async function() {

        const review = $(this).data("review")

        const rating = $(this).data("rating")

        const editReviewModal = new bootstrap.Modal(document.getElementById("editRvModal"), {})
        editReviewModal.show()

        $("#editRvModalReview").html(review)

        $(".edit-rv-modal-options").attr("selected", false)

        $(`.edit-rv-modal-options[value=${rating}]`).attr("selected", true)
    })

    $("#btnWishlist").click(async function() {
        if(!window.user){
            return alert("Please login to perform this action")
        }

        $("#btnWishlist").attr("disabled", true)

        const product_id = $(this).data("product_id")

        const response = await fetch(`/products/${product_id}/wishlists`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })

        if (response.status === 409) 
        {
            const { error } = await response.json()

            alert(error)
        } 
        else if (response.status === 200) 
        {
            const { success } = await response.json()

            alert(success)
        }

        $("#btnWishlist").attr("disabled", false)
    })

    function checkIsEmptyReview() {
        if($(".review").length == 0)
        {
            $("#reviewContainer").html(`<div class="alert alert-warning">No Reviews Found</div>`)
        }
    }

    $("#btnCart").click(async function() {
        if(!window.user){
            return alert("Please login to perform this action")
        }

        const quantity = $("#quantity").val()

        const product_id = $("#btnCart").data("product_id")

        if(Number(quantity) < 1)
        {
            return alert("Invalid quantity")
        }

        $("#btnCart").attr("disabled", true)

        const response = await fetch(`/products/${product_id}/cart`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({quantity})
        })

        if (response.status === 409) 
        {
            const { error } = await response.json()

            alert(error)
        } 
        else if (response.status === 200) 
        {
            const { success } = await response.json()

            alert(success)
        }

        $("#btnCart").attr("disabled", false)
    })
</script>
@endsection