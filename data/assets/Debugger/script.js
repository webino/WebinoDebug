(function () {
    var init = function () {
        // init wait
        setTimeout(function () {
            // resolve meta data
            var meta = document.getElementById('webino-debug-bar-meta');
            if (!meta) {
                init();
                return;
            }

            // custom bar title
            document.getElementById('tracy-debug-logo').title = meta.getAttribute('data-bar-title');

            // panel to float width fix
            var PanelToFloat = Tracy.DebugPanel.prototype.toFloat;
            Tracy.DebugPanel.prototype.toFloat = function () {
                PanelToFloat.call(this);
                this.elem.style.width = this.elem.offsetWidth + 'px';
                this.elem.style.height = this.elem.offsetHeight + 'px';
            };

        }, 1);
    };

    init();
})();
