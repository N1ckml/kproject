<!-- component -->
<!DOCTYPE html>
<html class="h-full" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="./tailwind.css" />
    @vite('resources/css/app.css')
    <title>Chi Desk</title>
    <style>
        html {
            font-size: 14px;
            line-height: 1.285;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Arial,
                sans-serif;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        /* can be configured in tailwind.config.js */
        .group:hover .group-hover\:block {
            display: block;
        }

        .focus\:cursor-text:focus {
            cursor: text;
        }

        .focus\:w-64:focus {
            width: 16rem;
        }

        /* zendesk styles */
        .h-16 {
            height: 50px;
        }

        .bg-teal-900 {
            background: #03363d;
        }

        .bg-gray-100 {
            background: #f8f9f9;
        }

        .hover\:border-green-500:hover {
            border-color: #78a300;
        }
    </style>
</head>

<body class="antialiased h-full">
    <!-- you can clone or fork the repo if you want -->
    <!-- https://github.com/bluebrown/tailwind-zendesk-clone   -->

    <div class="h-full w-full flex overflow-hidden antialiased text-gray-800 bg-white">
        <!-- section body side nav -->
        <nav aria-label="side bar" aria-orientation="vertical"
            class="flex-none flex flex-col items-center text-center bg-teal-900 text-gray-400 border-r">
            <div class="h-16 flex items-center w-full">
                <img class="h-6 w-6 mx-auto" src="https://raw.githubusercontent.com/bluebrown/tailwind-zendesk-clone/master/public/assets/leaves.png" />
            </div>

            <ul>
                <li>
                    <a title="Home" href="#home" class="h-16 px-6 flex items-center text-white bg-teal-700 w-full">
                        <i class="mx-auto">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M12 6.453l9 8.375v9.172h-6v-6h-6v6h-6v-9.172l9-8.375zm12 5.695l-12-11.148-12 11.133 1.361 1.465 10.639-9.868 10.639 9.883 1.361-1.465z" />
            </svg>
          </i>
                    </a>
                </li>
                <li>
                    <a title="Views" href="#views" class="h-16 px-6 flex items-center hover:text-white w-full">
                        <i class="mx-auto">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M18.546 3h-13.069l-5.477 8.986v9.014h24v-9.014l-5.454-8.986zm-3.796 12h-5.5l-2.25-3h-4.666l4.266-7h10.82l4.249 7h-4.669l-2.25 3zm-9.75-4l.607-1h12.787l.606 1h-14zm12.18-3l.607 1h-11.573l.607-1h10.359zm-1.214-2l.606 1h-9.144l.607-1h7.931z" />
            </svg>
          </i>
                    </a>
                </li>
                <li>
                    <a title="Customer Lists" href="#customer-lists"
                        class="h-16 px-6 flex items-center hover:text-white w-full">
                        <i class="mx-auto">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M19 7.001c0 3.865-3.134 7-7 7s-7-3.135-7-7c0-3.867 3.134-7.001 7-7.001s7 3.134 7 7.001zm-1.598 7.18c-1.506 1.137-3.374 1.82-5.402 1.82-2.03 0-3.899-.685-5.407-1.822-4.072 1.793-6.593 7.376-6.593 9.821h24c0-2.423-2.6-8.006-6.598-9.819z" />
            </svg>
          </i>
                    </a>
                </li>
                <li>
                    <a title="Reporting" href="#reporting" class="h-16 px-6 flex items-center hover:text-white w-full">
                        <i class="mx-auto">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M5 19h-4v-4h4v4zm6 0h-4v-8h4v8zm6 0h-4v-13h4v13zm6 0h-4v-19h4v19zm1 2h-24v2h24v-2z" />
            </svg>
          </i>
                    </a>
                </li>
                <li>
                    <a title="Admin" href="#admin" class="h-16 px-6 flex items-center hover:text-white w-full">
                        <i class="mx-auto">
            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z" />
            </svg>
          </i>
                    </a>
                </li>
            </ul>

        </nav>

        <div class="flex-1 flex flex-col">
            <!-- section body top nav -->
            <nav aria-label="top bar" class="flex-none flex justify-between bg-white h-16">

                <!-- top bar left -->
                <ul aria-label="top bar left" aria-orientation="horizontal" class="flex">

    </ul>

    <!-- to bar right  -->
    <ul aria-label="top bar right" aria-orientation="horizontal" class="px-8 flex items-center">
        <li class="relative">
            <input title="Search Bar" aria-label="search bar" role="search" class="pr-8 pl-4 py-2 rounded-md cursor-pointer transition-all duration-300 ease-in-out focus:border-black focus:cursor-text w-4 focus:w-64 placeholder-transparent focus:placeholder-gray-500" type="text" placeholder="Search Chi Desk Support" />
            <i class="pointer-events-none absolute top-0 right-0 h-full flex items-center pr-3">
            <svg class="fill-current w-4 h-4 mx-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path d="M21.172 24l-7.387-7.387c-1.388.874-3.024 1.387-4.785 1.387-4.971 0-9-4.029-9-9s4.029-9 9-9 9 4.029 9 9c0 1.761-.514 3.398-1.387 4.785l7.387 7.387-2.828 2.828zm-12.172-8c3.859 0 7-3.14 7-7s-3.141-7-7-7-7 3.14-7 7 3.141 7 7 7z" />
            </svg>
          </i>
        </li>



        <li class="h-10 w-10 ml-3">
            <button title="Page Menu" aria-label="page menu" class="h-full w-full rounded-full border focus:outline-none focus:shadow-outline">
            <img class="h-full w-full rounded-full mx-auto" src="https://raw.githubusercontent.com/bluebrown/tailwind-zendesk-clone/master/public/assets/me.jpg" />
          </button>
        </li>
    </ul>
    </nav>

    <!-- section body header -->
    <header aria-label="page caption" class="flex-none flex h-16 bg-gray-100 border-t px-4 items-center">
        <h1 id="page-caption" class="font-semibold text-lg">Dashboard</h1>
    </header>

    <!-- main content -->
    <main class="flex-grow flex min-h-0 border-t">
        <!-- section update to tickets -->
        <section class="flex flex-col p-4 w-full max-w-sm flex-none bg-gray-100 min-h-0 overflow-auto">
            <h1 class="font-semibold mb-3">
                Updates to your tickets
            </h1>
            <ul>
                <li>
                    <article tabindex="0"
                        class="cursor-pointer border rounded-md p-3 bg-white flex text-gray-700 mb-2 hover:border-green-500 focus:outline-none focus:border-green-500">
                        <span class="flex-none pt-1 pr-2">
                <img class="h-8 w-8 rounded-md" src="https://raw.githubusercontent.com/bluebrown/tailwind-zendesk-clone/master/public/assets/avatar.png" />
              </span>
                        <div class="flex-1">
                            <header class="mb-1">
                                Tarun T <span class="font-semibold">commented</span> on
                                <h1 class="inline">"RE: WPMS issue".</h1>
                            </header>
                            <p class="text-gray-600">
                                Hi Mazhar, Please note this issue comes when user is not
                                closing or logout sy…
                            </p>
                            <footer class="text-gray-500 mt-2 text-sm">
                                Friday 22:16
                            </footer>
                        </div>
                    </article>
                </li>
                
            </ul>
        </section>

        <!-- section content -->
        <section aria-label="main content" class="flex min-h-0 flex-col flex-auto border-l">
            <!-- content navigation -->
            <nav class="bg-gray-100 flex p-4">
                <!-- open tickets nav -->
                <section aria-labelledby="open-tickets-tabs-label" class="mr-4 focus:outline-none">
                    <label id="open-tickets-tabs-label" class="font-semibold block mb-1 text-sm">Open Tickets
              <span class="font-normal text-gray-700">(current)</span>
            </label>
                    <ul class="flex">
                        <li>
                            <button class="focus:outline-none focus:bg-yellow-200 p-2 rounded-l-md border border-r-0 bg-white flex flex-col items-center w-24">
                  <p class="font-semibold text-lg">6</p>
                  <p class="text-sm uppercase text-gray-600">
                    You
                  </p>
                </button>
                        </li>
                        <li>
                            <button class="focus:outline-none focus:bg-yellow-200 p-2 border rounded-r-md bg-white flex flex-col items-center w-24 cursor-pointer">
                  <p class="font-semibold text-lg">23</p>
                  <p class="text-sm uppercase text-gray-600">
                    Groups
                  </p>
                </button>
                        </li>
                    </ul>
                </section>
                <!-- stats nav -->
                <section aria-labelledby="ticket-statistics-tabs-label" class="pb-2">
                    <label id="ticket-statistics-tabs-label" class="font-semibold block mb-1 text-sm">Ticket Statistics
              <span class="font-normal text-gray-700">(this week)</span></label>
                    <ul class="flex">
                        <li>
                            <button class="focus:outline-none focus:bg-yellow-200 p-2 rounded-l-md border border-r-0 bg-white flex flex-col items-center w-24">
                  <p class="font-semibold text-lg">16</p>
                  <p class="uppercase text-gray-600 text-sm">
                    good
                  </p>
                </button>
                        </li>
                        <li>
                            <button class="focus:outline-none focus:bg-yellow-200 p-2 border border-r-0 bg-white flex flex-col items-center w-24">
                  <p class="font-semibold text-lg">2</p>
                  <p class="uppercase text-gray-600 text-sm">
                    bad
                  </p>
                </button>
                        </li>

                        <li>
                            <button class="focus:outline-none focus:bg-yellow-200 p-2 border rounded-r-md bg-white flex flex-col items-center w-24">
                  <p class="font-semibold text-lg">32</p>
                  <p class="uppercase text-gray-600 text-sm">
                    solved
                  </p>
                </button>
                        </li>
                    </ul>
                </section>
            </nav>

            <!-- content caption -->
            <header class="bg-white border-t flex items-center py-1 px-4">
                
            </header>

            <!-- content overflow section 
                remove table and thead but keep tbody and change tbody to section, in order
                to have scrollable overflow section -->
            <table aria-describedby="info-popup" aria-label="open tickets"
                class="border-t w-full min-h-0 h-full flex flex-col">
                
                <tbody class="flex w-full flex-col flex-1 min-h-0 overflow-hidden px-4">
                    