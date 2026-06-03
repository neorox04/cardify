<?php

namespace Tests\Unit;

use App\Http\Controllers\SubscriptionController;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionMethod;
use Tests\TestCase;

class SubscriptionTierTest extends TestCase
{
    private SubscriptionController $controller;
    private ReflectionMethod $getTier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new SubscriptionController();
        $this->getTier    = new ReflectionMethod($this->controller, 'getTier');
        $this->getTier->setAccessible(true);
    }

    // ── Price constants ────────────────────────────────────────────────────────

    public function test_price_constants_are_non_empty(): void
    {
        $this->assertNotEmpty(SubscriptionController::PRICE_INDIVIDUAL_MONTHLY);
        $this->assertNotEmpty(SubscriptionController::PRICE_INDIVIDUAL_YEARLY);
        $this->assertNotEmpty(SubscriptionController::PRICE_COMPANY);
    }

    public function test_all_three_price_ids_are_distinct(): void
    {
        $ids = [
            SubscriptionController::PRICE_INDIVIDUAL_MONTHLY,
            SubscriptionController::PRICE_INDIVIDUAL_YEARLY,
            SubscriptionController::PRICE_COMPANY,
        ];
        $this->assertCount(3, array_unique($ids), 'All three price IDs must be distinct.');
    }

    // ── Tier structure ─────────────────────────────────────────────────────────

    public function test_exactly_ten_tiers_are_defined(): void
    {
        $this->assertCount(10, SubscriptionController::TIERS);
    }

    public function test_tiers_cover_contiguous_range_starting_at_one(): void
    {
        $tiers = SubscriptionController::TIERS;
        $this->assertSame(1, $tiers[0]['min'], 'First tier must start at 1.');

        for ($i = 1; $i < count($tiers); $i++) {
            $this->assertSame(
                $tiers[$i - 1]['max'] + 1,
                $tiers[$i]['min'],
                "Gap between tier {$i} and tier " . ($i + 1) . '.'
            );
        }
    }

    public function test_tiers_end_at_10000(): void
    {
        $tiers = SubscriptionController::TIERS;
        $last  = $tiers[count($tiers) - 1];
        $this->assertSame(10000, $last['max']);
    }

    public function test_prices_are_strictly_decreasing_across_tiers(): void
    {
        $prices = array_column(SubscriptionController::TIERS, 'price');
        for ($i = 1; $i < count($prices); $i++) {
            $this->assertLessThan(
                $prices[$i - 1],
                $prices[$i],
                "Tier " . ($i + 1) . " price must be lower than tier {$i}."
            );
        }
    }

    public function test_cheapest_tier_is_tier_10(): void
    {
        $prices = array_column(SubscriptionController::TIERS, 'price');
        $this->assertSame(min($prices), $prices[count($prices) - 1]);
    }

    public function test_most_expensive_tier_is_tier_1(): void
    {
        $prices = array_column(SubscriptionController::TIERS, 'price');
        $this->assertSame(max($prices), $prices[0]);
    }

    // ── Tier boundary resolution ───────────────────────────────────────────────

    #[DataProvider('tierBoundaryProvider')]
    public function test_correct_price_returned_for_seat_count(int $seats, float $expectedPrice): void
    {
        $tier = $this->getTier->invoke($this->controller, $seats);
        $this->assertSame($expectedPrice, $tier['price'], "{$seats} seats should map to \${$expectedPrice}/seat.");
    }

    public static function tierBoundaryProvider(): array
    {
        return [
            // Tier 1 — 1–50 @ $9.50
            'T1 lower bound (1 seat)'    => [1,     9.50],
            'T1 midpoint   (25 seats)'   => [25,    9.50],
            'T1 upper bound (50 seats)'  => [50,    9.50],

            // Tier 2 — 51–100 @ $9.00
            'T2 lower bound (51 seats)'  => [51,    9.00],
            'T2 midpoint   (75 seats)'   => [75,    9.00],
            'T2 upper bound (100 seats)' => [100,   9.00],

            // Tier 3 — 101–250 @ $8.00
            'T3 lower bound (101 seats)' => [101,   8.00],
            'T3 midpoint   (175 seats)'  => [175,   8.00],
            'T3 upper bound (250 seats)' => [250,   8.00],

            // Tier 4 — 251–500 @ $7.00
            'T4 lower bound (251 seats)' => [251,   7.00],
            'T4 midpoint   (375 seats)'  => [375,   7.00],
            'T4 upper bound (500 seats)' => [500,   7.00],

            // Tier 5 — 501–750 @ $6.50
            'T5 lower bound (501 seats)' => [501,   6.50],
            'T5 midpoint   (625 seats)'  => [625,   6.50],
            'T5 upper bound (750 seats)' => [750,   6.50],

            // Tier 6 — 751–1 000 @ $6.00
            'T6 lower bound (751 seats)'  => [751,   6.00],
            'T6 midpoint   (875 seats)'   => [875,   6.00],
            'T6 upper bound (1000 seats)' => [1000,  6.00],

            // Tier 7 — 1 001–2 500 @ $5.50
            'T7 lower bound (1001 seats)' => [1001,  5.50],
            'T7 midpoint   (1750 seats)'  => [1750,  5.50],
            'T7 upper bound (2500 seats)' => [2500,  5.50],

            // Tier 8 — 2 501–5 000 @ $5.00
            'T8 lower bound (2501 seats)' => [2501,  5.00],
            'T8 midpoint   (3750 seats)'  => [3750,  5.00],
            'T8 upper bound (5000 seats)' => [5000,  5.00],

            // Tier 9 — 5 001–7 500 @ $4.50
            'T9 lower bound (5001 seats)' => [5001,  4.50],
            'T9 midpoint   (6250 seats)'  => [6250,  4.50],
            'T9 upper bound (7500 seats)' => [7500,  4.50],

            // Tier 10 — 7 501–10 000 @ $4.00
            'T10 lower bound (7501 seats)'  => [7501,  4.00],
            'T10 midpoint   (8750 seats)'   => [8750,  4.00],
            'T10 upper bound (10000 seats)' => [10000, 4.00],
        ];
    }

    // ── Boundary transitions ───────────────────────────────────────────────────

    #[DataProvider('tierTransitionProvider')]
    public function test_price_changes_correctly_at_tier_transition(
        int   $seatsBelow,
        int   $seatsAbove,
        float $priceBefore,
        float $priceAfter
    ): void {
        $before = $this->getTier->invoke($this->controller, $seatsBelow);
        $after  = $this->getTier->invoke($this->controller, $seatsAbove);

        $this->assertSame($priceBefore, $before['price']);
        $this->assertSame($priceAfter,  $after['price']);
    }

    public static function tierTransitionProvider(): array
    {
        return [
            'T1→T2  at 50→51'     => [50,   51,   9.50, 9.00],
            'T2→T3  at 100→101'   => [100,  101,  9.00, 8.00],
            'T3→T4  at 250→251'   => [250,  251,  8.00, 7.00],
            'T4→T5  at 500→501'   => [500,  501,  7.00, 6.50],
            'T5→T6  at 750→751'   => [750,  751,  6.50, 6.00],
            'T6→T7  at 1000→1001' => [1000, 1001, 6.00, 5.50],
            'T7→T8  at 2500→2501' => [2500, 2501, 5.50, 5.00],
            'T8→T9  at 5000→5001' => [5000, 5001, 5.00, 4.50],
            'T9→T10 at 7500→7501' => [7500, 7501, 4.50, 4.00],
        ];
    }

    // ── Overflow guard (above 10 000 handled at controller level) ─────────────

    public function test_get_tier_returns_last_tier_for_max_seats(): void
    {
        $tier = $this->getTier->invoke($this->controller, 10000);
        $this->assertSame(4.00, $tier['price']);
        $this->assertSame(10000, $tier['max']);
    }
}
