document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("main-image");
    const thumbnails = document.querySelectorAll(".thumbnail-image");

    if (!mainImage || thumbnails.length === 0) return;

    // サムネイルクリック時の処理
    thumbnails.forEach((thumb) => {
        thumb.addEventListener("click", function () {
            const newUrl = this.dataset.fullUrl;
            mainImage.src = newUrl;

            // 選択されたサムネイルの枠線を強調し、他のサムネイルの枠線をリセット
            thumbnails.forEach((t) => {
                t.style.borderColor = "transparent";
                t.style.opacity = "0.8";
            });
            // 選択されたサムネイルにプライマリカラーの枠線を適用
            this.style.borderColor = "var(--bs-primary)";
            this.style.opacity = "1";
        });
    });

    // 初回ロード時に1枚目のサムネイルに枠線を適用
    if (thumbnails.length > 0) {
        thumbnails[0].style.borderColor = "var(--bs-primary)";
        thumbnails[0].style.opacity = "1";
    }
});
