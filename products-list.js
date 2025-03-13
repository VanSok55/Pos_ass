document.addEventListener("DOMContentLoaded", () => {
    // Get all product cards
    const productCards = document.querySelectorAll(".product-card")

    // Add hover effect to product cards
    productCards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-8px)"
            this.style.boxShadow = "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)"
        })

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)"
            this.style.boxShadow = "0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01)"
        })
    })

    // Combine search and filter forms
    const searchForm = document.getElementById("search-form")
    const filterForm = document.getElementById("filter-form")
    const searchInput = document.getElementById("search-input")
    const categoryFilter = document.getElementById("category-filter")

    // When filter form changes, submit with search value included
    categoryFilter.addEventListener("change", () => {
        const searchValue = searchInput.value

        // Create hidden input for search value
        const hiddenInput = document.createElement("input")
        hiddenInput.type = "hidden"
        hiddenInput.name = "search"
        hiddenInput.value = searchValue

        // Add to filter form and submit
        filterForm.appendChild(hiddenInput)
        filterForm.submit()
    })

    // When search form submits, include category value
    searchForm.addEventListener("submit", (e) => {
        e.preventDefault()

        const categoryValue = categoryFilter.value

        // Create hidden input for category value
        const hiddenInput = document.createElement("input")
        hiddenInput.type = "hidden"
        hiddenInput.name = "category_filter"
        hiddenInput.value = categoryValue

        // Add to search form and submit
        searchForm.appendChild(hiddenInput)
        searchForm.submit()
    })

    // Clear filters button
    const clearFiltersBtn = document.getElementById("clear-filters")

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", () => {
            window.location.href = window.location.pathname
        })
    }

    // Confirm delete
    const deleteButtons = document.querySelectorAll(".btn-delete")

    deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            if (!confirm("Are you sure you want to delete this product?")) {
                e.preventDefault()
            }
        })
    })
})

