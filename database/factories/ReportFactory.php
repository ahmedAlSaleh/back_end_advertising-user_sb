<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * Creates reports with Arabic reasons and descriptions
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Report reasons (as per migration enum)
        $reasons = [
            'spam',          // محتوى مزعج أو غير مرغوب
            'fraud',         // احتيال أو خداع
            'inappropriate', // محتوى غير لائق
            'misleading',    // معلومات مضللة
            'offensive',     // محتوى مسيء
            'other',         // أخرى
        ];

        // Detailed descriptions in Arabic
        $descriptions = [
            'هذا الإعلان يحتوي على محتوى غير مناسب ويجب إزالته',
            'المعلومات المقدمة في هذا الإعلان مضللة وغير صحيحة',
            'تم التواصل مع صاحب الإعلان وتبين أنه احتيال',
            'الصور المستخدمة لا تمثل المنتج الفعلي',
            'السعر المعلن مختلف تماماً عن السعر الحقيقي',
            'هذا المتجر لا يلتزم بالمواعيد ويقدم خدمة سيئة',
            'محتوى مسيء ويتعارض مع سياسة المنصة',
            'نشر متكرر لنفس الإعلان (spam)',
            'استخدام صور مسروقة من مصادر أخرى',
            'محاولة الاحتيال والنصب على العملاء',
        ];

        // Status distribution (mostly pending)
        $statuses = ['pending', 'pending', 'pending', 'pending', 'reviewed', 'resolved', 'dismissed'];
        $status = fake()->randomElement($statuses);

        // Reporter types (users or traders can report)
        $reporterTypes = ['User', 'Trader'];
        $reporterType = fake()->randomElement($reporterTypes);

        // Reportable types (what can be reported)
        $reportableTypes = ['Advertisement', 'Store', 'Trader', 'Post'];

        // Admin notes (only for reviewed/resolved reports)
        $adminNotes = [
            'تم التحقق من البلاغ وهو صحيح',
            'تم اتخاذ الإجراءات اللازمة',
            'البلاغ غير صحيح',
            'تم التواصل مع المعلن',
            'تم حذف المحتوى المخالف',
            null, // Most reports don't have admin notes yet
            null,
            null,
        ];

        // Resolved dates and admin
        $resolvedAt = in_array($status, ['resolved', 'dismissed']) ? fake()->dateTimeBetween('-30 days', 'now') : null;
        $resolvedBy = $resolvedAt ? fake()->numberBetween(1, 5) : null; // Admin ID

        return [
            'reporter_id' => User::factory(), // Will be overridden by seeder if needed
            'reporter_type' => 'App\\Models\\' . $reporterType,
            'reportable_id' => null, // Will be set by seeder
            'reportable_type' => 'App\\Models\\' . fake()->randomElement($reportableTypes),
            'reason' => fake()->randomElement($reasons),
            'description' => fake()->randomElement($descriptions),
            'status' => $status,
            'admin_notes' => in_array($status, ['reviewed', 'resolved', 'dismissed']) ? fake()->randomElement($adminNotes) : null,
            'resolved_at' => $resolvedAt,
            'resolved_by' => $resolvedBy,
        ];
    }

    /**
     * Indicate that the report is pending
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'admin_notes' => null,
            'resolved_at' => null,
            'resolved_by' => null,
        ]);
    }

    /**
     * Indicate that the report is under review
     */
    public function reviewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reviewed',
        ]);
    }

    /**
     * Indicate that the report is resolved
     */
    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'resolved',
            'admin_notes' => 'تم حل المشكلة',
            'resolved_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'resolved_by' => fake()->numberBetween(1, 5),
        ]);
    }

    /**
     * Indicate that the report is dismissed
     */
    public function dismissed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dismissed',
            'admin_notes' => 'البلاغ غير صحيح',
            'resolved_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'resolved_by' => fake()->numberBetween(1, 5),
        ]);
    }
}
