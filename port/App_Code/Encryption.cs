using System;
using System.IO;
using System.Security.Cryptography;
using System.Text;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Encryption.php.
    /// PHP used mcrypt RIJNDAEL-128 in ECB mode with a random IV that was
    /// prepended to the ciphertext and base64'd (the IV is meaningless in ECB,
    /// but it is part of the stored format). .NET AES-128 == Rijndael-128 for
    /// 16-byte block/key sizes, so we reproduce the exact wire format:
    ///   base64( [16-byte random IV][AES-ECB(PKCS7 padding) ciphertext] )
    /// Decrypt strips the first 16 bytes and decrypts the rest, trimming NULs
    /// like the PHP version did (rtrim($plaintext, "\0")).
    /// </summary>
    public class Encryption
    {
        private readonly byte[] _key;

        public Encryption(string key)
        {
            // mcrypt pads/truncates the key to the cipher key size silently.
            byte[] raw = Encoding.UTF8.GetBytes(key ?? "");
            _key = new byte[16]; // RIJNDAEL_128 => 128-bit key in this usage
            Array.Copy(raw, _key, Math.Min(raw.Length, 16));
        }

        public string Encrypt(string plaintext)
        {
            byte[] iv = new byte[16];
            using (var rng = new RNGCryptoServiceProvider())
            {
                rng.GetBytes(iv);
            }

            byte[] cipher;
            using (var aes = new AesManaged
            {
                KeySize = 128,
                BlockSize = 128,
                Mode = CipherMode.ECB,
                Padding = PaddingMode.Zeros, // mcrypt zero-pads; PHP rtrim("\0") on decrypt
                Key = _key,
                IV = iv
            })
            using (var enc = aes.CreateEncryptor())
            {
                cipher = enc.TransformFinalBlock(Encoding.UTF8.GetBytes(plaintext ?? ""), 0, (plaintext ?? "").Length > 0 ? Encoding.UTF8.GetByteCount(plaintext) : 0);
            }

            byte[] outBytes = new byte[iv.Length + cipher.Length];
            Buffer.BlockCopy(iv, 0, outBytes, 0, iv.Length);
            Buffer.BlockCopy(cipher, 0, outBytes, iv.Length, cipher.Length);
            return Convert.ToBase64String(outBytes);
        }

        public string Decrypt(string ciphertextBase64)
        {
            byte[] all;
            try
            {
                all = Convert.FromBase64String(ciphertextBase64 ?? "");
            }
            catch (FormatException)
            {
                throw new Exception("Missing initialization vector");
            }

            const int ivSize = 16; // mcrypt_get_iv_size(RIJNDAEL_128, ECB)
            if (all.Length < ivSize)
            {
                throw new Exception("Missing initialization vector");
            }

            byte[] iv = new byte[ivSize];
            byte[] cipher = new byte[all.Length - ivSize];
            Buffer.BlockCopy(all, 0, iv, 0, ivSize);
            Buffer.BlockCopy(all, ivSize, cipher, 0, cipher.Length);

            using (var aes = new AesManaged
            {
                KeySize = 128,
                BlockSize = 128,
                Mode = CipherMode.ECB,
                Padding = PaddingMode.Zeros,
                Key = _key,
                IV = iv
            })
            using (var dec = aes.CreateDecryptor())
            using (var ms = new MemoryStream(dec.TransformFinalBlock(cipher, 0, cipher.Length)))
            using (var sr = new StreamReader(ms, Encoding.UTF8))
            {
                string result = sr.ReadToEnd();
                return result.TrimEnd('\0'); // rtrim($plaintext, "\0")
            }
        }
    }
}
