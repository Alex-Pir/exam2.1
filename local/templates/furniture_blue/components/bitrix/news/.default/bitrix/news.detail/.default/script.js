window.Review = function(parameters) {
    var self = this;
    self.date = parameters.DATE;
    self.type = parameters.TYPE,
    self.user = parameters.USER;
    self.newId = parameters.NEW_ID;
    self.url = parameters.URL;
    {
        self.sendReview = function() {
            BX.ajax({
                url: self.url,
                method: 'POST',
                data: {
                    "DATE": self.date,
                    "USER": self.user,
                    "NEW": self.newId,
                    "TYPE": self.type
                },
                dataType: "JSON",
                onsuccess: function(data) {
                    if (data.hasOwnProperty("MESSAGE")) {
                        self.printMessage(data.MESSAGE);
                    }
                },
                onfailure: function(error) {
                }
            });
        }
        self.printMessage = function(message) {
            var responseElement = document.getElementById("response-report");

            if (responseElement) {
                responseElement.innerText = message;
            } else {
                var element = document.createElement('span');
                element.setAttribute("id", "response-report");
                element.innerText = message;
                var link = document.getElementById("link-review");
                link.after(element);
            }
        }
    }
}