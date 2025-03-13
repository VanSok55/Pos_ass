document.addEventListener("DOMContentLoaded", () => {
    // File upload preview
    const fileInput = document.getElementById("image")
    const fileUpload = document.querySelector(".file-upload")
    const filePreview = document.querySelector(".file-upload-preview")
    const previewImg = document.querySelector(".file-upload-preview img")
    const fileName = document.querySelector(".file-upload-name")
    const uploadIcon = document.querySelector(".file-upload-icon")
    const uploadText = document.querySelector(".file-upload-text")

    // Create a new element for file selection status
    const fileStatus = document.createElement("div")
    fileStatus.className = "file-status"
    fileStatus.style.display = "none"

    // Insert the status element after the file upload area
    fileUpload.parentNode.insertBefore(fileStatus, fileUpload.nextSibling)

    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0]

        if (file) {
            const reader = new FileReader()

            // Clear the upload area content
            uploadIcon.innerHTML = ""
            uploadText.innerHTML = ""

            // Create file type icon based on mime type
            const fileIcon = document.createElement("i")

            if (file.type.startsWith("image/")) {
                fileIcon.className = "fas fa-file-image"
                fileIcon.style.color = "#3b82f6" // Blue for images
            } else if (file.type.startsWith("video/")) {
                fileIcon.className = "fas fa-file-video"
                fileIcon.style.color = "#ef4444" // Red for videos
            } else if (file.type.startsWith("audio/")) {
                fileIcon.className = "fas fa-file-audio"
                fileIcon.style.color = "#8b5cf6" // Purple for audio
            } else if (file.type.includes("pdf")) {
                fileIcon.className = "fas fa-file-pdf"
                fileIcon.style.color = "#ef4444" // Red for PDFs
            } else if (file.type.includes("word") || file.type.includes("document")) {
                fileIcon.className = "fas fa-file-word"
                fileIcon.style.color = "#2563eb" // Blue for documents
            } else if (file.type.includes("excel") || file.type.includes("sheet")) {
                fileIcon.className = "fas fa-file-excel"
                fileIcon.style.color = "#16a34a" // Green for spreadsheets
            } else {
                fileIcon.className = "fas fa-file"
                fileIcon.style.color = "#64748b" // Gray for other files
            }

            fileIcon.style.fontSize = "3rem"
            uploadIcon.appendChild(fileIcon)

            // Add file name and type
            const fileTypeInfo = document.createElement("div")
            fileTypeInfo.innerHTML = `
        <p class="file-name">${file.name}</p>
        <p class="file-type">${file.type || "Unknown type"}</p>
      `
            uploadText.appendChild(fileTypeInfo)

            // Add selected class to upload area
            fileUpload.classList.add("file-selected")

            reader.onload = (e) => {
                // Update preview image
                previewImg.src = e.target.result
                filePreview.style.display = "block"
                fileName.textContent = file.name
            }

            reader.readAsDataURL(file)
        }
    })
    // Drag and drop functionality
    ;["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
        fileUpload.addEventListener(eventName, preventDefaults, false)
    })

    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }
    ;["dragenter", "dragover"].forEach((eventName) => {
        fileUpload.addEventListener(eventName, highlight, false)
    })
    ;["dragleave", "drop"].forEach((eventName) => {
        fileUpload.addEventListener(eventName, unhighlight, false)
    })

    function highlight() {
        fileUpload.classList.add("dragover")
    }

    function unhighlight() {
        fileUpload.classList.remove("dragover")
    }

    fileUpload.addEventListener("drop", handleDrop, false)

    function handleDrop(e) {
        const dt = e.dataTransfer
        const file = dt.files[0]

        fileInput.files = dt.files

        if (file) {
            // Trigger the change event to handle the file
            const event = new Event("change")
            fileInput.dispatchEvent(event)
        }
    }

    // Form validation
    const form = document.getElementById("product-form")
    const productName = document.getElementById("product")
    const price = document.getElementById("price")
    const stock = document.getElementById("stock")

    form.addEventListener("submit", (e) => {
        let isValid = true

        // Simple validation
        if (productName.value.trim() === "") {
            showError(productName, "Product name is required")
            isValid = false
        } else {
            removeError(productName)
        }

        if (price.value.trim() === "" || isNaN(price.value)) {
            showError(price, "Please enter a valid price")
            isValid = false
        } else {
            removeError(price)
        }

        if (stock.value.trim() === "" || Number.parseInt(stock.value) < 0) {
            showError(stock, "Please enter a valid stock quantity")
            isValid = false
        } else {
            removeError(stock)
        }

        if (!fileInput.files[0]) {
            showError(fileUpload, "Please upload a product image")
            isValid = false
        } else {
            removeError(fileUpload)
        }

        if (!isValid) {
            e.preventDefault()
        }
    })

    function showError(input, message) {
        const formGroup = input.closest(".form-group")
        const errorElement = formGroup.querySelector(".error-message")

        if (!errorElement) {
            const error = document.createElement("div")
            error.className = "error-message"
            error.style.color = "var(--danger)"
            error.style.fontSize = "0.875rem"
            error.style.marginTop = "0.5rem"
            error.textContent = message

            formGroup.appendChild(error)
        } else {
            errorElement.textContent = message
        }

        input.style.borderColor = "var(--danger)"
    }

    function removeError(input) {
        const formGroup = input.closest(".form-group")
        const errorElement = formGroup.querySelector(".error-message")

        if (errorElement) {
            errorElement.remove()
        }

        input.style.borderColor = ""
    }

    // Back to dashboard button
    const backButton = document.getElementById("back-button")

    backButton.addEventListener("click", () => {
        window.location.href = "dashboard.php"
    })
})

