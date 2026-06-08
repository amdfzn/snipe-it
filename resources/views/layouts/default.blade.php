<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ Helper::determineLanguageDirection() }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta name="apple-mobile-web-app-capable" content="yes">


    <link rel="apple-touch-icon"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="apple-touch-startup-image"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="shortcut icon" type="image/ico"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ Helper::mapBackToLegacyLocale(app()->getLocale()) }}">
    <meta name="language-direction" content="{{ Helper::determineLanguageDirection() }}">
    <meta name="baseUrl" content="{{ config('app.url') }}/">
    <meta name="theme-color" content="{{ $snipeSettings->header_color ?? '#5fa4cc' }}">

    <script nonce="{{ csrf_token() }}">
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">

    {{-- page level css --}}
    @stack('css')


    <style>

        :root {
            color-scheme: light dark;
            --btn-theme-hover-text-color: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l - 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --btn-theme-hover: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l - 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --btn-theme-text-color: {{ $nav_link_color ?? 'light-dark(hsl(from var(--main-theme-color) h s calc(l + 10)),hsl(from var(--main-theme-color) h s calc(l - 10)))' }};
            --color-fg: light-dark(#373636, #ffffff);
            --main-footer-bg-color: light-dark(#ffffff,#3d4144);
            --main-footer-text-color: light-dark(#605e5e, #d2d6de);
            --main-footer-top-border-color: light-dark(#d2d6de,#605e5e);
            --main-theme-color: {{ $snipeSettings->header_color ?? '#3c8dbc' }};
            --nav-hover-text-color: {{ $nav_link_color ?? 'hsl(from var(--main-theme-color) h s calc(l - 10))' }};
            --nav-primary-text-color: {{ $nav_link_color ?? '#ffffff' }};
            --search-highlight: #e9d15b;
            --sidenav-hover-color-bg: #4c4b4b;
            --sidenav-text-hover-color: #fff;
            --sidenav-text-nohover-color: #b8c7ce;
            --table-border-row-color: light-dark(#ecf0f5, #656464);
            --table-border-row-top: 1px solid #ecf0f5;
            --table-border-row: 1px solid var(--table-border-row-color);
            --table-stripe-bg-alt: light-dark(rgba(211, 211, 211, 0.25), #323131);
            --table-stripe-bg: light-dark(#ffffff, #494747);
            --text-danger: light-dark(#a94442, #fa5b48);
            --text-help: light-dark(#777676,#a6a4a4);
            --text-info: light-dark(#31708f,#2baae6);
            --text-success: light-dark(#039516,#4ced61);
            --text-warning: light-dark(#da9113,#f3a51f);
        }

        [data-theme="light"] {
            color-scheme: light;
            --box-bg: #ffffff;
            --box-header-bottom-border-color: #f4f4f4;
            --box-header-bottom-border: 1px solid var(--box-header-bottom-border-color);
            --box-header-top-border-color: #d2d6de;
            --box-header-top-border: 3px solid var(--box-header-top-border-color);
            --btn-theme-base: hsl(from var(--main-theme-color) h s calc(l + 5));
            --btn-theme-border:  hsl(from var(--btn-theme-base) h s calc(l + 20));
            --btn-theme-hover-text-color:  var(--nav-primary-text-color);
            --btn-theme-hover: var(--main-theme-hover);
            --callout-bg-color: var(--box-header-bottom-border-color);
            --callout-left-border: var(--box-header-top-border-color);
            --color-bg: #ecf0f5;
            --header-color: #000000;
            --input-group-bg: hsl(from var(--box-bg) h s calc(l - 5));
            --input-group-fg: hsl(from var(--input-group-bg) h s calc(l - 50));
            --link-color: {{ $link_light_color ?? '#296282' }};
            --link-hover:  hsl(from var(--link-color) h s calc(l - 10));
            --main-theme-hover: hsl(from var(--main-theme-color) h s calc(l - 10));
            --tab-bottom-border: 1px solid var(--box-header-top-border-color);
            --text-legend-help: var(--text-help);

        }

        [data-theme="dark"] {
            color-scheme: dark;
            --box-bg: #3d4144;
            --box-header-bottom-border-color: #605e5e;
            --box-header-bottom-border: 1px solid var(--box-header-bottom-border-color);
            --box-header-top-border-color: #605e5e;
            --box-header-top-border: 3px solid var(--box-header-top-border-color);
            --btn-theme-base: hsl(from var(--main-theme-color) h s calc(l + 5));
            --btn-theme-border:  hsl(from var(--btn-theme-base) h s calc(l + 20));
            --btn-theme-hover-text-color:  var(--nav-primary-text-color);
            --btn-theme-hover: var(--main-theme-hover);
            --callout-bg-color: var(--box-header-top-border-color);
            --callout-left-border: #323131;
            --color-bg: #222222;
            --header-color: #ffffff;
            --input-group-bg: hsl(from var(--box-bg) h s calc(l + 10));
            --input-group-fg: hsl(from var(--input-group-bg) h s calc(l + 50));
            --link-color: {{ $link_dark_color ?? '#5fa4cc' }};
            --link-hover:  hsl(from var(--link-color) h s calc(l + 15));
            --main-theme-hover: hsl(from var(--main-theme-color) h s calc(l - 10));
            --tab-bottom-border: 1px solid var(--box-header-top-border-color);
            --text-legend-help: #d6d6d6;

        }

        .label2_fields,
        .l2fd-main,
        .l2fd-listitem,
        .fixed-table-loading,
        .list-group-item
        {
            background-color: var(--box-bg) !important;
            color: var(--color-fg) !important;
        }

        .list-group-item {
            border: var(--tab-bottom-border);
        }

        footer.main-footer {
            color: var(--main-footer-text-color) !important;
            background-color: var(--main-footer-bg-color) !important;
            border-top: 1px solid var(--main-footer-top-border-color) !important;
        }

        a,
        a:link,
        a:visited
        {
            color: var(--link-color);
        }

        a:hover,
        a:focus
        {
            color: var(--link-hover) !important;
        }


        .footer-links a {
            color: var(--link-color) !important;
        }

        h2 small {
            color: var(--color-fg) !important;
        }

        .btn-theme {
            background-color: var(--btn-theme-base);
            /*color: var(--btn-theme-hover-text-color) !important;*/
            color: var(--nav-primary-text-color) !important;
            border: 1px solid hsl(from var(--btn-theme-base) h s calc(l - 15)) !important;
        }

        .btn-theme:hover {
            background-color: var(--btn-theme-hover);
            /*color: var(--btn-theme-hover-text-color) !important;*/
            color: var(--nav-primary-text-color) !important;
            border: 1px solid hsl(from var(--btn-theme-base) h s calc(l - 15)) !important;
        }

        .btn-theme.active
        {
            background-color: var(--btn-theme-hover) !important;
        }

        .btn-theme:focus {
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-wrapper,
        .js-data-ajax,
        .option,
        .select2 .select2-container .select2-container--default,
        .select2,
        .select2-choice,
        .select2-container,
        .select2-results__option,
        .select2-search input,
        .select2-search--dropdown,
        .select2-search__field,
        .select2-selection .select2-selection--single,
        .select2-selection,
        .select2-selection--single,
        .select2-selection__rendered,
        input[type="date"],
        input[type="number"],
        input[type="text"],
        input[type="url"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        option:active,
        option[active],
        option[selected],
        select option,
        select,
        textarea
        {
            background-color: var(--table-stripe-bg) !important;
            color: var(--color-fg) !important;

        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
        }

        /**
        Multiselect maybe?
         */
        .select2-results__option[aria-selected=true]
        {
            background-color: var(--main-theme-color) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .select2-results__option[aria-selected=false]
        {
            background-color: var(--table-stripe-bg) !important;
            /*background-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;*/
            /*color: var(--nav-primary-text-color) !important;*/
            color: var(--color-fg) !important;
        }

        /**
        Highlight the select2 on hover when NOT the selected option
         */
        .select2-results__option--highlighted[aria-selected=false]
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 10)) !important;
            color: var(--nav-primary-text-color) !important;
        }

        /**
        Highlight the select2 on hover when the selected option
         */
        .select2-results__option--highlighted[aria-selected=true],
        .select2-results__option--highlighted[aria-selected=true]:hover,
        .select2-results__option--highlighted[aria-selected=true]:link,
        .select2-results__option--highlighted[aria-selected=true]:focus,
        .select2-results__option--highlighted[aria-selected=true]:visited
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;
            /*color: var(--color-fg) !important;*/
            color: var(--nav-primary-text-color) !important;
        }

        .select2-selection__choice,
        .select2-container--default .select2-selection--multiple .select2-selection__choice
        {
            background-color: var(--main-theme-color) !important;
            border-color: hsl(from var(--main-theme-color) h s calc(l - 15)) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .select2-selection__choice__remove {
            color: var(--nav-primary-text-color) !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
            color: var(--nav-primary-text-color) !important;
            overflow-y: auto;
        }


        .input-group-addon {
            background-color: var(--input-group-bg) !important;
            color: var(--input-group-fg) !important;
        }


        input[type="text"]:focus,
        input[type="url"]:focus,
        input[type="date"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        textarea:focus
        {
            border-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
        }

        *:disabled,
        input[readonly],
        textarea[readonly]
        {
            background-color: light-dark(rgb(234, 232, 232), rgb(117, 116, 117)) !important;
            border: 1px solid light-dark(rgb(234, 232, 232), rgb(117, 116, 117)) !important;
            cursor: not-allowed !important;
        }


        input[type="search"].search-highlight {
            background-color: var(--search-highlight);
            border: 1px solid hsl(from var(--search-highlight) h s calc(l - 20)) !important;
        }

        .content-wrapper {
            background-color: var(--color-bg);
        }

        .btn-anchor {
            outline: none !important;
            padding: 0;
            border: 0;
            padding-left: 20px;
            vertical-align: baseline;
            cursor: pointer;
        }

        h1,
        h2,
        h3,
        h4,
        p,
        .modal-title,
        .modal-header h2
        {
            color: var(--color-fg) !important;
        }

        .btn-danger,
        .btn-danger:hover,
        .btn-danger:focus,
        .btn-warning,
        .btn-warning:hover,
        .btn-warning:focus,
        .btn-primary,
        .btn-primary:hover,
        .btn-primary:focus,
        .modal-danger,
        .modal-danger h2,
        .modal-warning h2,
        .modal-danger h4,
        .modal-warning h4,
        .bg-maroon,
        .bg-maroon:hover,
        .bg-maroon:focus,
        .bg-purple,
        .bg-purple:hover,
        .bg-purple:focus
        {
            color: white !important;
        }


        .btn-selected,
        .btn-selected a,
        .btn-selected:hover,
        .btn-selected:focus {
            color: light-dark(hsl(from var(--main-theme-color) h s calc(l + 30)), hsl(from var(--main-theme-color) h s calc(l + 30))) !important;
            background-color: light-dark(hsl(from var(--main-theme-color) h s calc(l - 20)), hsl(from var(--main-theme-color) h s calc(l - 20))) !important;
            border-color: light-dark(hsl(from var(--main-theme-color) h s calc(l - 25)), hsl(from var(--main-theme-color) h s calc(l - 25))) !important;

        }

        .btn-default,
        .btn-default:hover
        {
            color: #3d4144 !important;
        }

        body
        {
            background-color: var(--color-bg);
            color: var(--color-fg);
        }



        label,
        .icon-med,
        .nav-tabs-custom > .nav-tabs > li > a,
        .nav-tabs-custom > .nav-tabs > li.active > a:link
        {
            color: var(--color-fg);
        }

        .popover.right .arrow:after
        {
            border-right-color: var(--box-bg) !important;
        }

        .popover.right .arrow {
            border-right-color: var(--box-bg) !important;
        }

        .table-bordered > tbody > tr > td,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > td,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > thead > tr > td,
        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > th,
        .table-bordered,
        .well
        {
            border: 1px solid var(--box-header-top-border-color) !important;
            border-left-color: var(--box-header-top-border-color) !important;
            border-right-color: var(--box-header-top-border-color) !important;
        }

        .box {
            border-top: 3px solid;
        }

        .box.box-default {
            border-top:  var(--box-header-top-border);
        }



        .box-header.with-border {
            border-bottom: var(--box-header-bottom-border);
        }

        .box-footer
        {
            border-top: var(--box-header-bottom-border);
        }


        .nav-tabs-custom > .nav-tabs {
            border-bottom: var(--tab-bottom-border);
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
            padding-bottom: 0;

        }

        .nav-tabs > li > a {
            margin-right: 0;
            border: 0;
        }

        .box,
        .box-footer,
        .tab-content,
        .nav-tabs-custom,
        .nav-tabs-custom > .nav-tabs > li,
        .nav-tabs-custom > .nav-tabs > li:first-of-type,
        .nav-tabs-custom > .nav-tabs > li.active > a:link,
        .nav-tabs-custom > .nav-tabs > li.active > a:visited,
        .nav-tabs-custom > .nav-tabs > li.active > a:hover,
        .bootstrap-table.fullscreen,
        .well
        {

            color: var(--color-fg);
            background-color: var(--box-bg) !important;
            border-left: 1px solid transparent;
            border-right: 1px solid  transparent;

        }

        .panel {
            border-color: var(--box-header-top-border-color);
        }
        .panel-body {
            background-color: var(--box-bg) !important;
        }

        .panel-heading,
        .panel-default > .panel-heading
        {
            color: var(--color-fg) !important;
            background-color: var(--table-stripe-bg-alt) !important;
            border-color: var(--box-header-top-border-color);
        }

        .panel-footer {
            background-color: var(--box-bg) !important;
            border-color: var(--box-header-top-border-color);
        }

        .nav-tabs-custom > .nav-tabs > li.active
        {
            border-top-color: var(--main-theme-color) !important;
            background-color: var(--box-header-top-border-color) !important;
            border-bottom: 2px solid  var(--box-bg) !important;
            border-right: 1px solid  var(--box-header-top-border-color) ;
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
        }

        .nav-tabs-custom > .nav-tabs > li:first-of-type {
            border-left: 0;
        }


        /**
        This fixes the weird spacing in the nav tabs if there is a badge count on the tab
         */
        .badge {
            font-size: 11px;
        }

        /**
        table rows
         */

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td
        {
            border-top: var(--table-border-row) !important;
        }


        .table-striped > tbody > tr:nth-of-type(even),
        .row-new-striped > .row:nth-of-type(even),
        .row-new-striped > .div:nth-of-type(odd),
        .cansort
        {
            background-color: var(--table-stripe-bg) !important;
            border-top: var(--table-border-row-top) !important;
            color: var(--color-fg) !important;
        }

        .table-striped > tbody > tr:nth-of-type(odd),
        .row-new-striped > .row:nth-of-type(even),
        .row-new-striped > .div:nth-of-type(odd),
        .cansort
        {
            background-color: var(--table-stripe-bg-alt) !important;
            border-top: var(--table-border-row-top) !important;
            color: var(--color-fg) !important;
        }




        /**
        main header nav
         */


        .dropdown-menu {
            background-color: var(--main-theme-color);
            border-color: var(--main-theme-color);
        }


        .dropdown-menu > li,
        .label-default,
        .label-default:hover
        {
            background-color: var(--main-theme-color);
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-menu > li > a:link,
        .dropdown-menu > li > a:visited,
        .dropdown-menu > .active > a:link,
        .dropdown-menu > .active > a:visited,
        .navbar-nav .open > a:link,
        .navbar-nav .open > a:visited,
        .navbar-nav > li > a:link,
        .navbar-nav > li > a:visited
        {
            background-color: var(--main-theme-color);
            /*background-color: rgba(0,0,0,.15);*/
            color: var(--nav-primary-text-color) !important;
            /*color: var(--nav-primary-text-color) !important;*/

        }

        .btn-tableButton.active.focus,
        .btn-tableButton.active:focus,
        .btn-tableButton.active:hover,
        .dropdown-menu > .active > a:focus,
        .dropdown-menu > .active > a:hover,
        .dropdown-menu > .active > a:link,
        .dropdown-menu > .active > a:visited,
        .dropdown-menu > li > a:focus,
        .dropdown-menu > li > a:hover,
        .dropdown-menu > li:focus,
        .dropdown-menu > li:hover,
        .navbar-nav .open  li.active > a:focus,
        .navbar-nav .open  li.active > a:hover,
        .navbar-nav .open > a:focus,
        .navbar-nav .open > a:hover,
        .navbar-nav > li > a:focus,
        .navbar-nav > li > a:hover,
        .open > .dropdown-toggle.btn-tableButton:focus,
        .open > .dropdown-toggle.btn-tableButton:hover,
        .page-next a,
        .pagination > .active > a:hover,
        .page-item.active,
        .pagination > .active > a,
        .pagination > li > .active > a,
        .pagination > li > .active > a:hover,
        .pagination > li > a:hover
        {
            background-color: var(--main-theme-hover) !important;
            border-color: var(--btn-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .pagination > li > a
        {
            background-color: var(--main-theme-color) !important;
            border-color: var(--btn-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }


        .bootstrap-table .fixed-table-toolbar li.dropdown-item-marker label
        {
            color: var(--nav-primary-text-color) !important;
        }

        .bootstrap-table .fixed-table-toolbar li.dropdown-item-marker label:hover
        {
            background-color: var(--main-theme-hover) !important;
            color: var(--nav-primary-text-color) !important;
        }


        .dropdown-menu,
        .dropdown-menu > li
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5));
            border-color: hsl(from var(--main-theme-color) h s calc(l - 10));
            color: var(--nav-primary-text-color) !important;
        }

        .navbar-nav > .notifications-menu > .dropdown-menu > li.header,
        .navbar-nav > .messages-menu > .dropdown-menu > li.header,
        .navbar-nav > .tasks-menu > .dropdown-menu > li.header,
        .navbar-nav > .notifications-menu > .dropdown-menu > li .menu,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu a:hover,
        .navbar-nav > .messages-menu > .dropdown-menu > li .menu, .navbar-nav > .tasks-menu > .dropdown-menu > li:hover,
        .navbar-nav > .tasks-menu > .dropdown-menu > li .menu > li:hover > a,
        .task_menu
        {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 5)) !important;
            color: var(--nav-primary-text-color) !important;
            margin-bottom: 0;
        }

        .navbar-nav > .notifications-menu > .dropdown-menu > li .menu > li > a, .navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a, .navbar-nav > .tasks-menu > .dropdown-menu > li .menu > li > a {
            border-bottom: 1px solid hsl(from var(--main-theme-color) h s calc(l - 10));
        }


        /**
        Active and hover for top tier sidenav items
         */

        .main-sidebar {
            background-color: #1e282c;
        }

        .sidebar-menu>li.active > a,
        .sidebar-menu>li:hover>a,
        .treeview-menu>li> a
        {
            color: var(--sidenav-text-hover-color) !important;
            border-left-color: var(--main-theme-color);
        }

        .sidebar-menu > li:hover > a,
        .sidebar-menu > li.active > a
        {
            border-left-color: var(--main-theme-color);
            padding-left: 12px;
        }


        .sidebar-menu > li:hover {
            background-color: #2c3b41;
        }

        .sidebar-menu>li>.treeview-menu
        {
            background-color: #1e282c;
        }


        .sidebar-menu > li > a:link,
        .sidebar-menu > li > a:visited,
        .treeview-menu>li> a
        {
            color: var(--sidenav-text-nohover-color) !important;
        }

        .sidebar-menu > li.active > a,
        .sidebar-menu > li:hover > a
        {
            background-color: #1e282c;
            border-left-color: var(--main-theme-color);
            border-left-style: solid;
            border-left-width: 3px;
            color: var(--sidenav-text-hover-color) !important;
        }

        thead,
        tbody,
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td

        {
            border-top-color: var(--box-bg) !important;
            border-bottom-color: var(--box-header-bottom-border-color) !important;
            color: var(--color-fg);
        }


        .help-block {
            color: var(--text-help) !important;
        }

        .alert-msg,
        .has-error
        {
            color: var(--text-danger) !important;
        }

        .has-error .form-control {
            border-color: var(--text-danger);
        }

        .alert a {
            color: white !important;
        }


        .text-dark-gray a:link,
        .text-dark-gray a:hover,
        .text-dark-gray a:visited,
        .text-dark-gray a:focus
        {
            color: hsl(from var(--main-theme-color) h s calc(l - 5));
        }

        .text-warning {
            color: var(--text-warning) !important;
        }

        .text-info {
            color: var(--text-info) !important;
        }

        .text-primary {
            color: var(--main-theme-color) !important;
        }

        .text-danger {
            color: var(--text-danger) !important;
        }

        .text-success {
            color: var(--text-success) !important;
        }

        .dropdown-menu > .divider {
            background-color: hsl(from var(--main-theme-color) h s calc(l - 10));
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 1px;

        }

        input[type="radio"]::before {
            box-shadow: inset 1em 1em hsl(from var(--main-theme-color) h s calc(l - 20)) !important;
        }


        input[type="checkbox"]::before {
            box-shadow: inset 1em 1em hsl(from var(--main-theme-color) h s calc(l - 20)) !important;
        }




        .callout.callout-legend {
            background-color: var(--callout-bg-color);
            border-left: 5px solid var(--callout-left-border);

        }

        .callout-legend h4 a,
        .callout-legend h4 a:hover
        {
            color: var(--color-fg) !important;
        }



        p.callout-subtext, p.callout-subtext a:hover, p.callout-subtext a:visited, p.callout-subtext a:link {
            color: var(--text-legend-help) !important;
            text-decoration: none;
        }


        legend {
            border-bottom: 1px solid var(--callout-left-border);
        }

        th,
        .fix-sticky table thead {
            background-color: var(--box-bg);
            color: var(--color-fg) !important;
        }

        .datepicker.dropdown-menu th, .datepicker.datepicker-inline th,
        .datepicker.dropdown-menu td,
        .datepicker.datepicker-inline td

        {
            color: var(--color-fg);
            border-color: var(--color-fg);
            background-color: var(--box-bg) !important;
        }

        .datepicker.dropdown-menu th:hover,
        .datepicker.datepicker-inline th:hover,
        .datepicker.dropdown-menu td:hover,
        .datepicker.datepicker-inline td:hover,
        .datepicker table tr td span:hover,
        .datepicker table tr td span.focused,
        .logo:hover
        {
            background-color: var(--main-theme-color) !important;
            color: var(--nav-primary-text-color) !important;
        }

        .datepicker.dropdown-menu,
        .modal-content,
        .popover.help-popover,
        .popover.help-popover .popover-content,
        .popover.help-popover .popover-body,
        .popover.help-popover .popover-title,
        .popover.help-popover .popover-header
        {
            background-color: var(--box-bg) !important;
            /*color: var(--color-fg) !important;*/
            color: contrast-color(var(--box-bg)) !important;
        }

        .treeview-menu > li {
            background-color: #2c3b41;
            color: var(--sidenav-text-nohover-color) !important;
        }

        .treeview-menu > li >a:hover,
        .treeview-menu > li:hover,
        .treeview-menu > li.active > a
        {
            color: white !important;
            background-color: var(--sidenav-hover-color-bg) !important;
            /*color: var(--sidenav-text-hover-color) !important;*/
        }

        .sidebar-toggle.btn,
        .sidebar-toggle.btn:hover
        {
            color: white !important;
        }

        .chart-responsive {
            color: var(--color-fg) !important;
        }

        .table > tbody + tbody {
            border-top: 0px !important;
        }

        h4#progress-text {
            color: white !important;
        }

        .small-box h3, .small-box p {
            color: inherit !important;
        }

        .box.box-theme {
            border-top:  var(--main-theme-color) !important;
        }

    </style>

    {{-- Custom CSS --}}
    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif


    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": {{ $snipeSettings->per_page }}
            }
        };
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>


</head>

    <body class="sidebar-mini{{ (session('menu_state')!='open') ? ' sidebar-mini sidebar-collapse' : ''  }}">

        <a class="skip-main" href="#main">{{ trans('general.skip_to_main_content') }}</a>
        <div class="wrapper">

            <header class="main-header inv-topbar-wrap">
                <nav class="navbar navbar-static-top inv-topbar" role="navigation">

                    {{-- Kiri: breadcrumb + judul --}}
                    <div class="inv-topbar-left">
                        <div class="inv-topbar-crumb">
                            Aplikasi Aset - UPA TIK Universitas Riau
                        </div>
                        <h1 class="inv-topbar-title">@yield('title')</h1>
                    </div>

                    {{-- Tengah: search --}}
                    @can('index', \App\Models\Asset::class)
                    <div class="inv-topbar-center">
                        <form class="inv-search-form" role="search" action="{{ route('findbytag/hardware') }}" method="get">
                            <i class="fas fa-search inv-search-icon"></i>
                            <input type="text" class="inv-search-input" name="assetTag" id="tagSearch" placeholder="Cari aset, tag, atau serial...">
                            <input type="hidden" name="topsearch" value="true">
                        </form>
                    </div>
                    @endcan

                    {{-- Kanan: actions --}}
                    <div class="inv-topbar-right">
                        @can('create', \App\Models\Asset::class)
                        <a href="{{ url('reports/custom') }}" class="inv-topbar-btn">
                            <i class="fas fa-download"></i>
                            <span>Ekspor</span>
                        </a>
                        <a href="{{ route('hardware.create') }}" class="inv-topbar-btn primary">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Aset</span>
                        </a>
                        @endcan

                        @can('admin')
                        <div class="inv-topbar-notif">
                            <?php $alert_items = ($snipeSettings->show_alerts_in_menu=='1') ? Helper::checkLowInventory() : []; ?>
                            <a href="#" class="inv-notif-btn dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                @if(count($alert_items) > 0)
                                <span class="inv-notif-dot"></span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @if(count($alert_items) == 0)
                                <li class="header">Tidak ada notifikasi</li>
                                @else
                                <li class="header">{{ count($alert_items) }} notifikasi</li>
                                @foreach($alert_items as $item)
                                <li><a href="{{ route($item['type'].'.show', $item['id']) }}">{{ $item['name'] }} — {{ $item['remaining'] }} tersisa</a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        @endcan

                        {{-- User menu --}}
                        @if (Auth::check())
                        <li class="dropdown user user-menu" style="list-style:none;">
                            <a href="#" class="dropdown-toggle inv-user-btn" data-toggle="dropdown">
                                @if (Auth::user()->present()->gravatar())
                                    <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image" alt="" style="width:32px;height:32px;border-radius:8px;">
                                @else
                                    <div class="inv-avatar">{{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name ?? '', 0, 1) }}</div>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @can('self.profile')
                                <li><a href="{{ route('view-assets') }}"><i class="fas fa-check fa-fw"></i> {{ trans('general.viewassets') }}</a></li>
                                @endcan
                                <li><a href="{{ route('profile') }}"><i class="fas fa-user fa-fw"></i> {{ trans('general.editprofile') }}</a></li>
                                @can('self.profile')
                                @if (Auth::user()->ldap_import!='1')
                                <li><a href="{{ route('account.password.index') }}"><i class="fas fa-key fa-fw"></i> {{ trans('general.changepassword') }}</a></li>
                                @endif
                                @endcan
                                <li><a href="" data-theme-toggle onclick="event.preventDefault();"><i class="fas fa-moon fa-fw"></i> {{ trans('general.dark_mode') }}</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('logout.get') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-fw"></i> {{ trans('general.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display:none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </div>

                    {{-- Sidebar toggle (hidden visually tapi tetap functional) --}}
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="display:none;">
                        <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    </a>

                </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- Logo area -->
                <a href="{{ route('home') }}" class="inv-sidebar-logo">
                    <img src="{{ url('img/logo-upa-tik-white.png') }}" alt="UPA TIK" class="inv-sidebar-logo-img">
                    <div class="inv-sidebar-logo-text">
                        <span class="inv-sidebar-logo-title">UPA TIK</span>
                        <span class="inv-sidebar-logo-sub">Universitas Riau</span>
                    </div>
                </a>
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">

                        {{-- SECTION: OPERASIONAL --}}
                        <li class="header">OPERASIONAL</li>

                        @can('admin')
                        <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!}>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-th-large fa-fw"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @endcan

                        @can('index', \App\Models\Asset::class)
                        <li {!! (request()->is('hardware*') || request()->is('maintenances*') ? ' class="active"' : '') !!}>
                            <a href="{{ url('hardware') }}">
                                <i class="fas fa-laptop fa-fw"></i>
                                <span>Aset</span>
                                @if(isset($total_assets) && $total_assets > 0)
                                    <span class="badge">{{ $total_assets }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        @can('index', \App\Models\Asset::class)
                        <li {!! (request()->is('hardware') && request()->query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                            <a href="{{ url('hardware?status=Deployed') }}">
                                <i class="fas fa-hand-holding fa-fw"></i>
                                <span>Peminjaman</span>
                                @if(isset($total_deployed_sidebar) && $total_deployed_sidebar > 0)
                                    <span class="badge">{{ $total_deployed_sidebar }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        @can('view', \App\Models\AssetMaintenance::class)
                        <li {!! (request()->is('maintenances*') ? ' class="active"' : '') !!}>
                            <a href="{{ route('maintenances.index') }}">
                                <i class="fas fa-wrench fa-fw"></i>
                                <span>Perbaikan</span>
                                @if(isset($total_maintenances_sidebar) && $total_maintenances_sidebar > 0)
                                    <span class="badge">{{ $total_maintenances_sidebar }}</span>
                                @endif
                            </a>
                        </li>
                        @endcan

                        @can('reports.view')
                        <li {!! (request()->is('reports*') ? ' class="active"' : '') !!}>
                            <a href="{{ route('reports.activity') }}">
                                <i class="fas fa-chart-bar fa-fw"></i>
                                <span>Laporan</span>
                            </a>
                        </li>
                        @endcan

                        {{-- SECTION: MASTER DATA --}}
                        <li class="header">MASTER DATA</li>

                        @can('view', \App\Models\Category::class)
                        <li {!! (request()->is('categories*') ? ' class="active"' : '') !!}>
                            <a href="{{ route('categories.index') }}">
                                <i class="fas fa-tags fa-fw"></i>
                                <span>Kategori</span>
                            </a>
                        </li>
                        @endcan

                        @can('view', \App\Models\Location::class)
                        <li {!! (request()->is('locations*') ? ' class="active"' : '') !!}>
                            <a href="{{ route('locations.index') }}">
                                <i class="fas fa-map-marker-alt fa-fw"></i>
                                <span>Lokasi</span>
                            </a>
                        </li>
                        @endcan

                        @can('view', \App\Models\User::class)
                        <li {!! (request()->is('users*') ? ' class="active"' : '') !!}>
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-users fa-fw"></i>
                                <span>Pengguna</span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper" role="main" id="setting-list">

                @if ($debug_in_production)
                    <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                        <div class="col-md-12"
                             style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                            <x-icon type="warning" class="fa-3x pull-left"/>
                            <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                            {!! trans('general.debug_warning_text') !!}
                        </div>
                    </div>
                @endif

                <!-- Content Header (Page header) -->
                <section class="content-header">


                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 0px;">

                        <style>
                            .breadcrumb-item {
                                display: inline;
                                list-style: none;
                            }
                        </style>

                            <h1 class="pull-left pagetitle inv-page-greeting">
                                <?php
                                $hour = now()->hour;
                                $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 17 ? 'Selamat Siang' : 'Selamat Malam');
                                ?>
                                {{ $greeting }}, {{ Auth::user()->first_name ?? 'Admin' }} 👋
                            </h1>

                                @if (isset($helpText))
                                    @include ('partials.more-info',
                                                           [
                                                               'helpText' => $helpText,
                                                               'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                                                           ])
                                @endif
                                <div class="pull-right">
                                    @yield('header_right')
                                </div>

                        </div>
                    </div>
                </section>


                <section class="content" id="main" tabindex="-1" style="padding-top: 0px;">

                    <!-- Notifications -->
                    <div class="row">
                        @if (config('app.lock_passwords'))
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    {{ trans('general.some_features_disabled') }}
                                </div>
                            </div>
                        @endif

                        @include('notifications')
                    </div>


                    <!-- Content -->
                    <div id="{!! (request()->is('*api*') ? 'app' : 'webui') !!}">
                        @yield('content')
                    </div>

                </section>

            </div><!-- /.content-wrapper -->
            <footer class="main-footer hidden-print" style="display:grid;flex-direction:column;">

                <div class="hidden-xs pull-left">
                    <div class="pull-left footer-links">
                         {!! trans('general.footer_credit') !!}

                        <a target="_blank" href="https://bsky.app/profile/snipeitapp.com" rel="noopener" data-tooltip="true" data-title="Join us on Bluesky">
                            <i class="fa-brands fa-square-bluesky fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://github.com/grokability/snipe-it/" rel="noopener" data-tooltip="true" data-title="Join us on Github">
                            <i class="fa-brands fa-square-github fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://hachyderm.io/@grokability" rel="noopener" data-tooltip="true" data-title="Join us on Mastodon">
                            <i class="fa-brands fa-mastodon fa-fw"></i>
                        </a>
                        <a target="_blank" href="https://discord.gg/yZFtShAcKk" rel="noopener" data-tooltip="true" data-title="Join us on Discord">
                            <i class="fa-brands fa-discord fa-fw"></i>
                        </a>

                    </div>
                    <div class="pull-right">
                    @if ($snipeSettings->version_footer!='off')
                        @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            &nbsp; {{ trans('general.version') }} {{ config('version.app_version') }} -
                            {{ trans('general.build') }} {{ config('version.build_version') }} ({{ config('version.branch') }})
                        @endif
                    @endif

                    @if (isset($user) && ($user->isSuperUser()) && (app()->environment('local')))
                       <a href="{{ url('telescope') }}" class="label label-default" rel="noopener">Open Telescope</a>
                    @endif




                    @if ($snipeSettings->support_footer!='off')
                        @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <a target="_blank" class="label label-default"
                               href="https://snipe-it.readme.io/docs/overview"
                               rel="noopener">{{ trans('general.user_manual') }}</a>
                            <a target="_blank" class="label label-default" href="https://snipeitapp.com/support/"
                               rel="noopener">{{ trans('general.bug_report') }}</a>
                        @endif
                    @endif

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a target="_blank" class="label label-default" rel="noopener"
                           href="{{  $snipeSettings->privacy_policy_link }}"
                           target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
                    @endif
                    </div>
                    <br>
                    @if ($snipeSettings->footer_text!='')
                        <div class="pull-left">
                            {!!  Helper::parseEscapedMarkedown($snipeSettings->footer_text)  !!}
                        </div>
                    @endif
                </div>
            </footer>
        </div><!-- ./wrapper -->


        <!-- end main container -->

        <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="dataConfirmModalLabel">
                            <span class="modal-header-icon"></span>&nbsp;
                        </h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="deleteForm" role="form" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirmModalLabel">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="restoreForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- Javascript files --}}
        <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url('js/select2/i18n/'.Helper::mapBackToLegacyLocale(app()->getLocale()).'.js') }}"></script>

        {{-- Page level javascript --}}
        @stack('js')

        @section('moar_scripts')
        @show


        <script nonce="{{ csrf_token() }}">

            //color picker with addon
            $(".color").colorpicker();


            /**
             * Utility function to calculate the current theme setting.
             * Look for a local storage value.
             * Fall back to system setting.
             * Fall back to light mode.
             */
            function calculateSettingAsThemeString({ localStorageTheme, systemSettingDark }) {
                if (localStorageTheme !== null) {
                    return localStorageTheme;
                }

                if (systemSettingDark.matches) {
                    return "dark";
                }

                return "light";
            }

            /**
             * Utility function to update the button text and aria-label.
             */
            function updateButton({ buttonEl, isDark }) {
                const newCta = isDark ? '<i class="fa-regular fa-sun fa-fw"></i>  {{ trans('general.light_mode') }}' : '<i class="fa-solid fa-moon fa-fw"></i>   {{ trans('general.dark_mode') }}';
                // use an aria-label if omitting text on the button
                // and using a sun/moon icon, for example
                buttonEl.setAttribute("aria-label", newCta);
                buttonEl.innerHTML = newCta;
            }

            /**
             * Utility function to update the theme setting on the html tag
             */
            function updateThemeOnHtmlEl({ theme }) {
                document.querySelector("html").setAttribute("data-theme", theme);
            }


            /**
             * On page load:
             */

            /**
             * 1. Grab what we need from the DOM and system settings on page load
             */

            const button = document.querySelector("[data-theme-toggle]");
            const localStorageTheme = localStorage.getItem("theme");
            const systemSettingDark = window.matchMedia("(prefers-color-scheme: dark)");
            const clearButton = document.querySelector("[data-theme-toggle-clear]");

            /**
             * 2. Work out the current site settings
             */
            let currentThemeSetting = calculateSettingAsThemeString({ localStorageTheme, systemSettingDark });

            /**
             * 3. Update the theme setting and button text according to current settings
             */
            updateButton({ buttonEl: button, isDark: currentThemeSetting === "dark" });
            updateThemeOnHtmlEl({ theme: currentThemeSetting });

            /**
             * 4. Add an event listener to toggle the theme
             */
            button.addEventListener("click", (event) => {
                const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

                localStorage.setItem("theme", newTheme);
                updateButton({ buttonEl: button, isDark: newTheme === "dark" });
                updateThemeOnHtmlEl({ theme: newTheme });

                currentThemeSetting = newTheme;
            });




            $.fn.datepicker.dates['{{ app()->getLocale() }}'] = {
                days: [
                    "{{ trans('datepicker.days.sunday') }}",
                    "{{ trans('datepicker.days.monday') }}",
                    "{{ trans('datepicker.days.tuesday') }}",
                    "{{ trans('datepicker.days.wednesday') }}",
                    "{{ trans('datepicker.days.thursday') }}",
                    "{{ trans('datepicker.days.friday') }}",
                    "{{ trans('datepicker.days.saturday') }}"
                ],
                daysShort: [
                    "{{ trans('datepicker.short_days.sunday') }}",
                    "{{ trans('datepicker.short_days.monday') }}",
                    "{{ trans('datepicker.short_days.tuesday') }}",
                    "{{ trans('datepicker.short_days.wednesday') }}",
                    "{{ trans('datepicker.short_days.thursday') }}",
                    "{{ trans('datepicker.short_days.friday') }}",
                    "{{ trans('datepicker.short_days.saturday') }}"
                ],
                daysMin: [
                    "{{ trans('datepicker.min_days.sunday') }}",
                    "{{ trans('datepicker.min_days.monday') }}",
                    "{{ trans('datepicker.min_days.tuesday') }}",
                    "{{ trans('datepicker.min_days.wednesday') }}",
                    "{{ trans('datepicker.min_days.thursday') }}",
                    "{{ trans('datepicker.min_days.friday') }}",
                    "{{ trans('datepicker.min_days.saturday') }}"
                ],
                months: [
                    "{{ trans('datepicker.months.january') }}",
                    "{{ trans('datepicker.months.february') }}",
                    "{{ trans('datepicker.months.march') }}",
                    "{{ trans('datepicker.months.april') }}",
                    "{{ trans('datepicker.months.may') }}",
                    "{{ trans('datepicker.months.june') }}",
                    "{{ trans('datepicker.months.july') }}",
                    "{{ trans('datepicker.months.august') }}",
                    "{{ trans('datepicker.months.september') }}",
                    "{{ trans('datepicker.months.october') }}",
                    "{{ trans('datepicker.months.november') }}",
                    "{{ trans('datepicker.months.december') }}",
                ],
                monthsShort:  [
                    "{{ trans('datepicker.months_short.january') }}",
                    "{{ trans('datepicker.months_short.february') }}",
                    "{{ trans('datepicker.months_short.march') }}",
                    "{{ trans('datepicker.months_short.april') }}",
                    "{{ trans('datepicker.months_short.may') }}",
                    "{{ trans('datepicker.months_short.june') }}",
                    "{{ trans('datepicker.months_short.july') }}",
                    "{{ trans('datepicker.months_short.august') }}",
                    "{{ trans('datepicker.months_short.september') }}",
                    "{{ trans('datepicker.months_short.october') }}",
                    "{{ trans('datepicker.months_short.november') }}",
                    "{{ trans('datepicker.months_short.december') }}",
                ],
                today: "{{ trans('datepicker.today') }}",
                clear: "{{ trans('datepicker.clear') }}",
                format: "yyyy-mm-dd",
                weekStart: {{ $snipeSettings->week_start ?? 0 }},
            };

            var clipboard = new ClipboardJS('.js-copy-link');

            clipboard.on('success', function(e) {
                e.text = e.text.replace(/^\s/, '').trim();
                var clickedElement = $(e.trigger);
                clickedElement.tooltip('hide').attr('data-original-title', '{{ trans('general.copied') }}').tooltip('show');
            });


            // Reference: https://jqueryvalidation.org/validate/
            var validator = $('#create-form').validate({
                ignore: 'input[type=hidden]',
                errorClass: 'alert-msg',
                errorElement: 'div',
                errorPlacement: function(error, element) {

                    if ($(element).hasClass('select2') || $(element).hasClass('js-data-ajax')) {
                        // If the element is a select2 then append the error to the parent div
                        element.parent('div').append(error);

                     } else if ($(element).parent().hasClass('input-group')) {
                        var end_input_group = $(element).next('.input-group-addon').parent();
                        error.insertAfter(end_input_group);
                    } else {
                        error.insertAfter(element);
                    }

                },
                highlight: function(inputElement) {

                    // We have to go two levels up if it's an input group
                    if ($(inputElement).parent().hasClass('input-group')) {
                        $(inputElement).parent().parent().parent().addClass('has-error');
                    } else {
                        $(inputElement).parent().addClass('has-error');
                        $(inputElement).closest('.help-block').remove();
                    }

                },
                onfocusout: function(element) {
                    // We have to go two levels up if it's an input group
                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().parent().parent().removeClass('has-error');
                        return $(element).valid();
                    } else {
                        $(element).parent().removeClass('has-error');
                        return $(element).valid();
                    }

                },

            });

            $.extend($.validator.messages, {
                required: "{{ trans('validation.generic.required') }}",
                email: "{{ trans('validation.generic.email') }}"
            });


            function showHideEncValue(e) {
                // Use element id to find the text element to hide / show
                var targetElement = e.id+"-to-show";
                var hiddenElement = e.id+"-to-hide";
                var audio = new Audio('{{ config('app.url') }}/sounds/lock.mp3');
                if($(e).hasClass('fa-lock')) {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-lock').addClass('fa-unlock');
                    // Show the encrypted custom value and hide the element with asterisks
                    document.getElementById(targetElement).style.fontSize = "100%";
                    document.getElementById(hiddenElement).style.display = "none";

                } else {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-unlock').addClass('fa-lock');
                    // ClipboardJS can't copy display:none elements so use a trick to hide the value
                    document.getElementById(targetElement).style.fontSize = "0px";
                    document.getElementById(hiddenElement).style.display = "";

                 }
             }

            $(function () {

                // This handles the show/hide for cloned items
                $('#use_cloned_image').click(function() {
                    if ($('#use_cloned_image').is(':checked')) {
                        $('#image_delete').prop('checked', false);
                        $('#image-upload').hide();
                        $('#existing-image').show();
                    } else {
                        $('#image-upload').show();
                        $('#existing-image').hide();
                    }
                    //$('#image-upload').hide();
                });

                // Invoke Bootstrap 3's tooltip
                $('[data-tooltip="true"]').tooltip({
                    container: 'body',
                    animation: true,
                });

                $('[data-toggle="popover"]').popover();
                $('.select2 span').addClass('needsclick');
                $('.select2 span').removeAttr('title');

                // This javascript handles saving the state of the menu (expanded or not)
                $('body').bind('expanded.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                        _token: "{{ csrf_token() }}"
                    });

                });

                $('body').bind('collapsed.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                        _token: "{{ csrf_token() }}"
                    });
                });

            });

            // Initiate the ekko lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
            //This prevents multi-click checkouts for accessories, components, consumables
            $(document).ready(function () {
                $('#checkout_form').submit(function (event) {
                    event.preventDefault();
                    $('#submit_button').prop('disabled', true);
                    this.submit();
                });
            });

            // Select encrypted custom fields to hide them in the asset list
            $(document).ready(function() {
                // Selector for elements with css-padlock class
                var selector = 'td.css-padlock';

                // Function to add original value to elements
                function addValue($element) {
                    // Get original value of the element
                    var originalValue = $element.text().trim();

                    // Show asterisks only for not empty values
                    if (originalValue !== '') {
                        // This is necessary to avoid loop because value is generated dynamically
                        if (originalValue !== '' && originalValue !== asterisks) $element.attr('value', originalValue);

                        // Hide the original value and show asterisks of the same length
                        var asterisks = '*'.repeat(originalValue.length);
                        $element.text(asterisks);

                        // Add click event to show original text
                        $element.click(function() {
                            var $this = $(this);
                            if ($this.text().trim() === asterisks) {
                                $this.text($this.attr('value'));
                            } else {
                                $this.text(asterisks);
                            }
                        });
                    }
                }
                // Add value to existing elements
                $(selector).each(function() {
                    addValue($(this));
                });

                // Function to handle mutations in the DOM because content is generated dynamically
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        // Check if new nodes have been inserted
                        if (mutation.type === 'childList') {
                            mutation.addedNodes.forEach(function(node) {
                                if ($(node).is(selector)) {
                                    addValue($(node));
                                } else {
                                    $(node).find(selector).each(function() {
                                        addValue($(this));
                                    });
                                }
                            });
                        }
                    });
                });

                // Configure the observer to observe changes in the DOM
                var config = { childList: true, subtree: true };
                observer.observe(document.body, config);
            });


        </script>

        @if ((session()->get('topsearch')=='true') || (request()->is('/')))
            <script nonce="{{ csrf_token() }}">
                $("#tagSearch").focus();
            </script>
        @endif

        </body>
</html>
