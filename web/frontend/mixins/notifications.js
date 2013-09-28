Notifications.prototype.push = function(options) {
    var note;
    options._dismiss = this.onDismiss;
    note = new Notification(this.notificationTemplate, options);
    this.flipIn(note.view);
    return {
        index:this.notifications.push(note),
        notification: note
    }
};