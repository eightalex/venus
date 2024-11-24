document.addEventListener('DOMContentLoaded', generateTableOfContents);

document.addEventListener('DOMContentLoaded', function() {
    const tocTitle = document.querySelector('.table-of-contents__title');

    if (!tocTitle) {
        return;
    }

    tocTitle.addEventListener('click', () => {
        const tocList = document.querySelector('.table-of-contents');

        if (tocList) {
            tocList.classList.toggle('hidden');
        }
    });
});

function generateTableOfContents() {
    const contentBlocks = document.querySelectorAll('.variable-content');

    if (!contentBlocks.length) {
        return;
    }

    const isExcludedId = [
        ...php_vars.toc_excluded_pages,
        ...php_vars.toc_excluded_posts,
    ].includes(php_vars.current_id);

    if (isExcludedId) {
        return;
    }

    const toc = document.createElement('div');
    toc.className = 'table-of-contents';
    toc.innerHTML = '<h2 class="table-of-contents__title">Innholdsfortegnelse</h2>';

    const tocList = document.createElement('ul');
    let globalCounter = 0;

    const headings = document.querySelectorAll([
        '.section__title',
        '.variable-content > h2',
        '.variable-content > h3',
        '.variable-content > h4',
        '.variable-content > h5',
        '.variable-content > h6'
    ].join(', '));

    let currentNumber = [];

    headings.forEach((header, index) => {
        const headerId = `toc-heading-${index}`;
        header.id = headerId;

        const level = parseInt(header.tagName[1]);
        while (currentNumber.length < level - 1) {
            currentNumber.push(0);
        }
        while (currentNumber.length > level - 1) {
            currentNumber.pop();
        }
        currentNumber[currentNumber.length - 1]++;
        globalCounter++;

        const listItem = document.createElement('li');
        const link = document.createElement('a');

        link.style.marginLeft = `${(level - 2) * 20}px`;

        if (level === 1) {
            link.style.marginLeft = '0';
        }

        link.href = `#${headerId}`;
        link.textContent = header.textContent;
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById(headerId).scrollIntoView({ behavior: 'smooth' });
        });
        listItem.appendChild(link);
        tocList.appendChild(listItem);
    });

    toc.appendChild(tocList);

    const firstContentBlock = contentBlocks[0];
    const paragraphs = firstContentBlock.querySelectorAll('.variable-content > p');

    if (paragraphs.length >= 2) {
        paragraphs[1].after(toc);
    } else {
        firstContentBlock.append(toc);
    }

    const listItems = tocList.querySelectorAll('li');
    let totalHeight = 0;

    listItems.forEach(item => {
        totalHeight += item.offsetHeight + 3;
    });

    tocList.style.maxHeight = `${totalHeight}px`;
}
