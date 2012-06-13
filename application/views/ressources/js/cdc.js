
function show_news_table(flux_id) {

    $('#NewsTableContainer').jtable({
        title: 'Les news du flux "'+flux_id+'"',
        actions: {
            listAction: 'getNews/'+flux_id,
            createAction: 'createNews/'+flux_id,
            updateAction: 'updateNews/'+flux_id,
            deleteAction: 'deleteNews/'+flux_id
        },
        fields: {
            id: {
                key: true,
                create: false,
                edit: false,
                list: false
            },
            title: {
                title: 'Title',
                width: '20%'
            },
            small_description: {
                title: 'Description Courte',
                type: 'textarea',
                width: '20%'
            },
            text: {
                title: 'Text',
                type: 'textarea',
                width: '70%',
            }
        }
    });

    $('#NewsTableContainer').jtable('load');
}


