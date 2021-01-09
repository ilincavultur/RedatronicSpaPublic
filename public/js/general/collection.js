var $collectionContainerClass = '.collection-container',
    $collectionContainer = $($collectionContainerClass);

$(function () {

    $(document.body)

        .on({
            click: function (e) {
                e.preventDefault();

                var $collectionContainer = $(this).closest($collectionContainerClass);
                addCollection($collectionContainer);

                if ($collectionContainer.data('max-count') &&
                    $collectionContainer.data('max-count') <= $collectionContainer.find('.collections').children().length) {
                    $(this).hide();
                }
            }
        }, '.add-collection')

        .on({
            click: function (e) {
                var $this = $(this),
                    $collectionContainer = $this.closest($collectionContainerClass),
                    $parentToRemove;
                e.preventDefault();

                // $this.tooltip('hide');
                $parentToRemove = $this.closest('.form-group');
                if (!$parentToRemove.parent().is('.collections')) {
                    $parentToRemove = $parentToRemove.parent().closest('.form-group');
                }
                $parentToRemove.remove();

                if ($collectionContainer.data('max-count') &&
                    $collectionContainer.data('max-count') > $collectionContainer.find('.collections').children().length) {
                    $collectionContainer.find('.add-collection').show();
                }
            }
        }, '.delete-collection')

        .on({
            click: function (e) {
                var $this = $(this),
                    $href = $this.data('href');

                e.preventDefault();
                $.ajax({
                    url: $href,
                    type: 'POST'
                }).done(function ($response) {
                    if($response.success){
                        $this.closest('.form-group').remove();
                        showFlashMessage('success', $response.message);
                    }
                });
            }
        }, '.delete-attachment')

        .on({
            click: function (e) {
                var $this = $(this);

                confirm($this.data('message'), $this.data('confirm'), $this.data('cancel'), function ($confirmed) {
                    if ($confirmed) {
                        e.preventDefault();
                        $this.tooltip('hide');
                        $this.closest('.form-group').remove();
                    }
                });
            }
        }, '.delete-collection-confirm')

        .on({
            click: function (e) {
                var $this = $(this);

                if (confirm($this.data('message'), $this.data('confirm'), $this.data('cancel'))) {
                    e.preventDefault();
                    $this.tooltip('hide');
                    $this.closest('.form-group').remove();
                };
            }
        }, '.delete-collection-confirm-native')

    ;

    $collectionContainer.each(function () {
        var $this = $(this),
            $collections = $this.children('.collections'),
            $itemsNr = $collections.children().length;

        $this.data('index', $itemsNr);

        if (0 === $itemsNr && $this.data('default')) {
            $this.find('.add-collection').click();
            if ($this.data('geolocate')) {
                setGeoLocation($this.find('.form-control').first());
            }
        }

        if ($this.data('max-count') &&
            $this.data('max-count') <= $itemsNr) {
            $this.find('.add-collection').hide();
        }
    });

});

function addCollection($collectionContainer) {

    var $prototype = $collectionContainer.data('prototype'),
        $regex = /^[-_A-Za-z]+([0-9]+)[-_A-Za-z]*$/;

    var $index = $collectionContainer.children().children().length;

    $index = $index + 1;

    $collectionContainer.children('.collections').append($prototype.replace(/___collection_placeholder___/g, $index));
    $collectionContainer.data('index', $index);

    $('.on-new-collection-row-button').click();
}