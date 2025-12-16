document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll(".new-image-url-input");
    const clearButtons = document.querySelectorAll(".btn-clear-url");

    // 1. URL入力とプレビューの同期処理（入力、ペースト、クリアに対応）
    const updatePreview = function (input) {
        const previewId = input.dataset.previewId;
        const previewImg = document.getElementById(previewId);
        const url = input.value.trim(); // 前後の空白を削除

        if (previewImg) {
            if (url) {
                // URLがある場合は表示
                previewImg.src = url;
                previewImg.style.display = "block";
            } else {
                // URLがない場合は非表示
                previewImg.src = "";
                previewImg.style.display = "none";
            }
        }
    };

    // 初期ロード時の設定と、入力イベントリスナーの設定
    inputs.forEach((input) => {
        // 初期ロード時のプレビューを設定
        updatePreview(input);

        // inputイベント（入力、ペースト、クリアなど全てをカバー）
        input.addEventListener("input", function () {
            updatePreview(this);
        });
    });

    // 2. クリアボタンの処理（値を空にして、inputイベントを発火させる）
    clearButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // ボタンの近くにある input 要素を取得
            const input = this.closest(".input-group").querySelector(
                ".new-image-url-input"
            );

            if (input) {
                input.value = ""; // 値をクリア

                // inputイベントを強制的に発火させ、上記 updatePreview が動作するようにする
                const event = new Event("input", { bubbles: true });
                input.dispatchEvent(event);
            }
        });
    });
});
