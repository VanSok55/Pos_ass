document.addEventListener("DOMContentLoaded", () => {
    // Get DOM elements
    const sidebar = document.querySelector(".sidebar")
    const mobileToggle = document.querySelector(".mobile-toggle")
    const sidebarToggle = document.querySelector(".sidebar-toggle")

    // Mobile sidebar toggle
    mobileToggle.addEventListener("click", () => {
        sidebar.classList.toggle("active")
    })

    // Sidebar close button
    sidebarToggle.addEventListener("click", () => {
        sidebar.classList.remove("active")
    })

    // Close sidebar when clicking outside on mobile
    document.addEventListener("click", (event) => {
        const isClickInsideSidebar = sidebar.contains(event.target)
        const isClickOnMobileToggle = mobileToggle.contains(event.target)

        if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains("active")) {
            sidebar.classList.remove("active")
        }
    })

    // Get first letter of username for avatar
    const username = document.querySelector(".user-name").textContent
    const userAvatar = document.querySelector(".user-avatar")
    if (username && userAvatar) {
        userAvatar.textContent = username.charAt(0).toUpperCase()
    }

    // Add hover effect to cards
    const cards = document.querySelectorAll(".card")
    cards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px)"
            this.style.boxShadow = "var(--shadow-lg)"
        })

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)"
            this.style.boxShadow = "var(--shadow)"
        })
    })
})

