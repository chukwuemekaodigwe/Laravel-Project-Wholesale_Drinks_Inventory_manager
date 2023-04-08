export function smartPagination(links, window = 2) {
    let last = links.length - 2;
    let active_link = links.filter(link => link.active);

    let current = parseInt(active_link[0].label),
        left = current - window,
        right = current + window + 1,
        range = [],
        l;

    for (let i = 1; i <= last; i++) {
        if (i == 1 || i == last || i >= left && i < right) {
            range.push(i);
        }
    }
    
    // Build pagination, start with [< Previous]
    let new_links = [links[0]]

    for (let i of range) {
        if (l) {
            if (i - l === 2) {
                new_links.push(links[l + 1]);
                
            } else if (i - l !== 1) {
                new_links.push({"label":'...', "url": null, "active": false});
            }
        }
        new_links.push(links[i]);
        l = i;
    };

    // Build pagination, add [> Next] link
    new_links.push(links[links.length - 1])

    return new_links
    ;
};