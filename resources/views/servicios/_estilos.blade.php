<style>
    .services-page {
        --gold: #A99045;
        --gold-light: #D8C17F;
        --cream: #F5F3ED;
        --panel: #1D1D1D;

        background: #151515;
        color: var(--cream);
        isolation: isolate;
    }

    .services-page .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        padding: .65rem 1rem;
        border: 1px solid rgba(169,144,69,.4);
        border-radius: 999px;
        background: rgba(169,144,69,.08);
        color: var(--gold-light);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    .services-page .section-label {
        color: var(--gold-light);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
    }

    .services-page .gold-text {
        color: var(--gold-light);
    }

    .services-page .service-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(169,144,69,.24);
        border-radius: 1.2rem;
        background: linear-gradient(
            145deg,
            rgba(255,255,255,.045),
            rgba(255,255,255,.012)
        );
        transition: transform .25s ease, border-color .25s ease,
                    box-shadow .25s ease;
    }

    .services-page .service-card::before {
        position: absolute;
        top: 0;
        left: 12%;
        right: 12%;
        height: 1px;
        background: linear-gradient(
            90deg, transparent, rgba(216,193,127,.8), transparent
        );
        content: "";
    }

    .services-page .service-card:hover {
        transform: translateY(-5px);
        border-color: rgba(216,193,127,.65);
        box-shadow: 0 18px 42px rgba(0,0,0,.28);
    }

    .services-page .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .85rem 1rem;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: .85rem;
        background: rgba(255,255,255,.025);
        color: #d1d1d1;
        font-size: .875rem;
        transition: all .2s ease;
    }

    .services-page .category-link:hover,
    .services-page .category-link.active {
        border-color: rgba(216,193,127,.55);
        background: rgba(169,144,69,.12);
        color: var(--gold-light);
    }

    .services-page .gold-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        border: 1px solid rgba(216,193,127,.65);
        border-radius: 999px;
        background: var(--gold);
        padding: .75rem 1.25rem;
        color: #151515;
        font-size: .8rem;
        font-weight: 800;
        transition: all .25s ease;
    }

    .services-page .gold-button:hover {
        transform: translateY(-2px);
        background: var(--gold-light);
        box-shadow: 0 8px 24px rgba(169,144,69,.18);
    }

    .services-page .outline-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        border: 1px solid rgba(216,193,127,.35);
        border-radius: 999px;
        padding: .7rem 1rem;
        color: var(--gold-light);
        font-size: .8rem;
        font-weight: 700;
        transition: all .25s ease;
    }

    .services-page .outline-button:hover {
        border-color: var(--gold-light);
        background: rgba(169,144,69,.1);
    }

    .services-page a:focus-visible {
        outline: 2px solid var(--gold-light);
        outline-offset: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .services-page *,
        .services-page *::before,
        .services-page *::after {
            transition-duration: .01ms !important;
        }
    }
</style>
