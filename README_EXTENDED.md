# php-sepa Bibliothek - Erweiterte Version

Diese erweiterte Version der php-sepa Bibliothek unterstützt sowohl die ursprüngliche pain.008.001.08 als auch die ältere pain.008.001.02 Version für SEPA-Lastschriften.

## Unterstützte SEPA-Formate

### Lastschriften (Direct Debit)
- **pain.008.001.08** - Moderne Version (Standard)
- **pain.008.001.02** - Ältere Version (für Legacy-Systeme)

### Überweisungen (Credit Transfer)
- **pain.001.001.09** - Standard für Überweisungen

## Verwendung der pain.008.001.02 Version

```php
require_once 'src/autoload.php';

$validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();

// Verwende DirectDebitLegacy für pain.008.001.02
$sepa = new \ufozone\phpsepa\Sepa\DirectDebitLegacy($validatorFactory);
$sepa->setInitiator('Max Mustermann');

$payment = new \ufozone\phpsepa\Sepa\Payment($validatorFactory);
$payment->setAccount('Max Mustermann', 'DE02370501980001802057', 'COLSDE33');
$payment->setCreditorId('DE98ZZZ09999999999');

$transaction = new \ufozone\phpsepa\Sepa\Transaction($validatorFactory);
$transaction->setEndToEndId('R2017742-1')
    ->setName('Karl Kümmel')
    ->setIban('DE02300209000106531065')
    ->setBic('CMCIDEDD')
    ->setAmount(123.45)
    ->setMandateId('M20170704-200')
    ->setMandateDate('2017-07-04')
    ->setReference('Rechnung R2017742 vom 17.06.2017');

$payment->addTransaction($transaction);
$sepa->addPayment($payment);

$xml = new \ufozone\phpsepa\Sepa\Xml($sepa);
echo $xml->get();
```

## Verwendung der pain.008.001.08 Version (Standard)

```php
// Verwende DirectDebit für pain.008.001.08 (Standard)
$sepa = new \ufozone\phpsepa\Sepa\DirectDebit($validatorFactory);
// ... Rest des Codes bleibt gleich
```

## Unterschiede zwischen den Versionen

### pain.008.001.02
- Ältere, einfachere Struktur
- Weniger Validierungen
- Kompatibel mit älteren Bankensystemen
- Namespace: `urn:iso:std:iso:20022:tech:xsd:pain.008.001.02`

### pain.008.001.08
- Moderne, erweiterte Struktur
- Stärkere Validierungen
- Zusätzliche Felder und Optionen
- Namespace: `urn:iso:std:iso:20022:tech:xsd:pain.008.001.08`

## Integration in Laravel-Projekte

In deinem `SepaXmlService` kannst du beide Versionen verwenden:

```php
public function generateDirectDebitXml($invoices, SepaSettings $settings)
{
    $validatorFactory = new \ufozone\phpsepa\Sepa\Validator\Factory();
    
    // Wähle die passende pain-Version basierend auf den Einstellungen
    $painFormat = $settings->pain_format ?? 'pain.008.001.08';
    
    if ($painFormat === 'pain.008.001.02') {
        $sepa = new \ufozone\phpsepa\Sepa\DirectDebitLegacy($validatorFactory);
    } else {
        $sepa = new \ufozone\phpsepa\Sepa\DirectDebit($validatorFactory);
    }
    
    // ... Rest der Implementierung
}
```

## Beispiele

- `examples/debit.php` - pain.008.001.08 (Standard)
- `examples/debit_legacy.php` - pain.008.001.02 (Legacy Version)

## Wichtige Hinweise

1. **Bank-Kompatibilität**: Teste beide Versionen bei deiner Bank
2. **Validierung**: Beide Versionen werden automatisch validiert
3. **XSD-Schemas**: Alle benötigten Schemas sind im `vendor/schema/` Verzeichnis enthalten
4. **Namespace**: Die XML-Generierung verwendet automatisch den korrekten Namespace

## Lizenz

BSD 2-Clause License - siehe LICENSE Datei
