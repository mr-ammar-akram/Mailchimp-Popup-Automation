document.addEventListener("DOMContentLoaded", function () {

    if (!window.MPA_SETTINGS) return;

    const {
        enableSubscription,
        enableThankYou,
        popupId
    } = MPA_SETTINGS;

    let cookieSet = false;

    if (enableSubscription) {
        document.addEventListener('submit', function (e) {

            if (cookieSet) return;

            const form = e.target;
            if (!form.classList.contains('mc4wp-form')) return;

            const popup = popupId
                ? document.querySelector('.spu-box#' + popupId)
                : form.closest('.spu-box');

            if (!popup) return;

            setTimeout(() => {
                const response = form.querySelector('.mc4wp-response');
                if (!response) return;

                setCookie('wp_popup_subscribed', 'yes', 1825);
                cookieSet = true;
                popup.style.display = 'none';

            }, 800);

        }, true);
    }

    if (enableThankYou) {
        // Remove unwanted popup immediately
    const popup = document.querySelector('.spu-box#' + popupId);
    if (popup && document.cookie.includes('wp_popup_subscribed=yes')) {
        popup.remove();
    }
        setTimeout(() => {
            if (getCookie('wp_popup_subscribed') &&
                !getCookie('thankyou_popup_triggered')) {

                const trigger = document.querySelector('.thankyou-popup');
                if (!trigger) return;

                trigger.click();
                setCookie('thankyou_popup_triggered', 'yes', 1825);
            }
        }, 800);
    }

});

/* Cookie helpers */
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 86400000));
    document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/; SameSite=Lax`;
}

function getCookie(name) {
    return document.cookie.split('; ').find(row => row.startsWith(name + '='));
}
