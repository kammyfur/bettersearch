function switchAppPanel() {
    if (document.querySelector('[apppanel=""]').classList.contains('hide')) {
        document.querySelector('[apppanel=""]').classList.remove('hide')
    } else {
        document.querySelector('[apppanel=""]').classList.add('hide')
    }
}