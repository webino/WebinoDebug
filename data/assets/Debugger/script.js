setTimeout(function () {
    // custom bar title
    document.getElementById('tracy-debug-logo').title = document.getElementById('webino-debug-bar-meta').getAttribute('data-bar-title');

    // panel to float width fix
    var PanelToFloat = Tracy.DebugPanel.prototype.toFloat;
    Tracy.DebugPanel.prototype.toFloat = function () {
        PanelToFloat.call(this);
        this.elem.style.width = this.elem.offsetWidth + 'px';
        this.elem.style.height = this.elem.offsetHeight + 'px';
    };
}, 1);
