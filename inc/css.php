<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
<link href="<?= getRootUrl() ?>/vendors/simplebar/simplebar.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
<link href="<?= getRootUrl() ?>/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
<link href="<?= getRootUrl() ?>/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
<link href="<?= getRootUrl() ?>/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
<link href="<?= getRootUrl() ?>/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">

<script>
    var phoenixIsRTL = window.config.config.phoenixIsRTL;
    if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
</script>

<link href="<?= getRootUrl() ?>/vendors/leaflet/leaflet.css" rel="stylesheet">
<link href="<?= getRootUrl() ?>/vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
<link href="<?= getRootUrl() ?>/vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">
<link href="<?= getRootUrl() ?>/assets/css/form-error.css" rel="stylesheet" />
<link href="<?= getRootUrl() ?>/vendors/choices/choices.min.css" rel="stylesheet" />
<link href="<?= getRootUrl() ?>/vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
<style>
    .none-full {
        max-width: 150px;   
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
    }

    .none-full.expanded {
        max-width: none;
        overflow: visible;
        white-space: normal;
        background-color: rgba(0, 0, 0, 0.1);
    }

    table {
        position: relative;
        overflow: auto;
    }

    thead {
        position: sticky;
        top: 65px;
        z-index: 100;
        background-color: var(--phoenix-body-bg);
        box-shadow: 0px 0px 10px 4px rgba(0, 0, 0, 0.1);
    }

    .table-responsive {
        overflow-x: initial;
    }

    .scrollbar {
        overflow: initial;
    }

    
</style>