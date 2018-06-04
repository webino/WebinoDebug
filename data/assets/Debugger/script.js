window.WebinoDebug = (function () {
    var self = {
        ajax: function(method, url, data, success) {
            var oldTracyAutoRefresh = window.TracyAutoRefresh;
            window.TracyAutoRefresh = false;
            var ajax = new XMLHttpRequest;
            ajax.open(method, url);
            ajax.setRequestHeader('X-Tracy-Ajax', false);
            ajax.onreadystatechange = function (event) {
                switch (event.target.readyState) {
                    case 4:
                        success && success(event.target.responseText);
                        break;
                }
            }
            ajax.send(data);
            window.TracyAutoRefresh = oldTracyAutoRefresh;
            return self;
        },
        get: function(url, success) {
            self.ajax('GET', url, success);
            return self;
        },
        post: function(url, data, success) {
            self.ajax('GET', url, data, success);
            return self;
        }
    };

    return self;
})();

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
