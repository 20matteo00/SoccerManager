<?php
class Pagination
{
    private int $totalRecords;
    private int $perPage;
    private int $currentPage;
    private int $totalPages;
    private string $pageParam;    // il nome del parametro per il numero di pagina
    private string $perPageParam; // il nome del parametro per per-page

    public function __construct(
        int $totalRecords,
        int $perPage = 10,
        int $currentPage = 1,
        string $pageParam = 'pag',
        string $perPageParam = 'perPage'
    ) {
        $this->totalRecords  = $totalRecords;
        $this->perPage       = max(1, $perPage);
        $this->currentPage   = max(1, $currentPage);
        $this->pageParam     = $pageParam;
        $this->perPageParam  = $perPageParam;
        $this->totalPages    = max(1, (int)ceil($totalRecords / $this->perPage));
        // Se la pagina richiesta oltrepassa il massimo, ricadere sull'ultima
        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }
    }

    /** restituisce l'OFFSET per la query */
    public function getLimit(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /** genera i link di paginazione in formato <li class="page-item">… */
    public function generatePagination(string $baseUrl): string
    {
        $links = '';

        // Link '<<' inizio
        $links .= $this->pageItem(1, '&laquo;');

        // Link '<' precedente
        $prev = max(1, $this->currentPage - 1);
        $links .= $this->pageItem($prev, '&lsaquo;');

        // Numeri di pagina
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $links .= $this->pageItem($i, (string)$i, $i === $this->currentPage);
        }

        // Link '>' successivo
        $next = min($this->totalPages, $this->currentPage + 1);
        $links .= $this->pageItem($next, '&rsaquo;');

        // Link '>>' fine
        $links .= $this->pageItem($this->totalPages, '&raquo;');

        return $links;
    }

    /** crea un singolo <li>…<a>…</a></li> */
    private function pageItem(int $page, string $label, bool $active = false): string
    {
        $classes = 'page-item' . ($active ? ' active' : '');
        $url = $this->buildUrl($page);
        return <<<HTML
                <li class="$classes">
                <a class="page-link" href="$url">$label</a>
                </li>
                HTML;
    }

    /** costruisce l'URL con i parametri corretti */
    private function buildUrl(int $page): string
    {
        // Mantieni gli altri GET tranne il pageParam e perPageParam
        $query = [];
        foreach ($_GET as $k => $v) {
            if ($k !== $this->pageParam && $k !== $this->perPageParam) {
                $query[$k] = $v;
            }
        }
        // Aggiungi i parametri di paginazione
        $query[$this->pageParam]    = $page;
        $query[$this->perPageParam] = $this->perPage;

        // Ricomponi la query string
        $qs = http_build_query($query);

        // Se baseUrl ha già ?, non serve, ma qui lo passiamo così com’è
        return $base = $_SERVER['PHP_SELF'] . '?' . $qs;
    }

    public function generatefilter(array $query, string $page)
    {
        echo '<div class="d-flex overflow-auto my-3 py-3 gap-3">';
        foreach ($query as $stato) {
            $label = htmlspecialchars($stato['parent_id'] ?? $stato['stato'] ?? ''); // adattabile a entrambi i casi
            $value = urlencode($label);
            echo '<a href="index.php?page='.$page.'&parent=' . $value . '" 
                  class="btn btn-outline-primary text-decoration-none rounded-pill px-4 flex-shrink-0">'
                . $label .
                '</a>';
        }
        echo '</div>';
    }
}
