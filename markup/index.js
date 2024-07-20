function importFile(iframe) {
    iframe.before((iframe.contentDocument.body || iframe.contentDocument).children[0]);
    iframe.remove();
}
